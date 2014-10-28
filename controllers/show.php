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

        // Set infobox
        $this->addToInfobox(_('Aktionen'), '<a rel="lightbox" href=' . $this->url_for('show/edit') . '>' . _('Neuen Log hinzufügen') . '</a>');
        $this->setInfoBoxImage('infobox/archiv.jpg');
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

        // Set infobox
        $this->addToInfobox(_('Suchen'), '<input type="text" class="content_search">');
        $this->setInfoBoxImage('infobox/archiv.jpg');
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
