<?php

class ShowController extends StudipController {

    public function __construct($dispatcher) {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
    }

    public function before_filter(&$action, &$args) {

        if (Request::isXhr()) {
            $this->set_content_type('text/html;Charset=windows-1252');
        } else {
            $this->set_layout($GLOBALS['template_factory']->open('layouts/base'));
            $this->loadNavigation();
        }
    }

    public function index_action() {

        // Set sidebar
        $sidebar = Sidebar::Get();
        $actions = new ActionsWidget();
        $actions->addLink( _('Neuen Log hinzufügen'), $this->url_for('show/edit'), 'icons/16/blue/add.png')->asDialog('size=auto');
        $sidebar->addWidget($actions);
    }

    public function edit_action($id = null) {
        $this->log = new LogReader($id);

        if (Request::submitted('store')) {
            $this->log->setData(Request::getArray("logreader"));
            $this->log->store();
            $this->redirect('');
        }
    }

    public function view_action($id) {
        $this->log = $this->logs->find($id);
        
        $this->lines = count($this->log->file);
        $this->from = Request::int('from', 0);
        $this->to = Request::int('to', min(array($this->lines, 1000)));

        // Set sidebar
        $sidebar = Sidebar::Get();
        
        $search = new SearchWidget($this->url_for('show/view'));
        $search->addNeedle(_('Suche'), 'log_search', true);
        $sidebar->addWidget($search);
        
        $info = new SidebarWidget();
        $info->setTitle('Zeilen');
        $info->addElement(new WidgetElement(count($this->log->file)));
        $sidebar->addWidget($info);
        
        $select = new SidebarWidget();
        $select->setTitle('Ausgabe');
        $form = new WidgetElement('<form><label>'._('von').' <input style="width: 90px" type="text" name="from" value="'.$this->from.'"></label><label> '._('bis').' <input style="width: 90px" type="text" name="to" value="'.$this->to.'"></label>'.\Studip\Button::create(_('Anzeigen')).'</form>');
        $select->addElement($form);
        $sidebar->addWidget($select);
    }

    public function delete_action($id) {
        $this->log = LogReader::find($id);

        if (Request::submitted('confirm')) {
            $this->log->delete();
            $this->redirect('show/index');
        }

        if (Request::submitted('abort')) {
            $this->redirect('show/index');
        }
    }

    private function loadNavigation() {
        Navigation::addItem('/admin/logreaderplugin/overview', new AutoNavigation(_('Übersicht'), $this->url_for('show')));
        $this->loadLogs();
        foreach ($this->logs as $log) {
            if ($log->file) {
                Navigation::addItem('/admin/logreaderplugin/' . $log->id, new AutoNavigation(htmlReady($log->name), $this->url_for('show/view/' . $log->id)));
            }
        }
    }

    private function loadLogs() {
        $this->logs = LogReader::findAll();
        $this->logs = SimpleORMapCollection::createFromArray($this->logs);
    }

    // customized #url_for for plugins
    function url_for($to) {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    }

}
