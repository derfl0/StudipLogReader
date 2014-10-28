<?php

require 'bootstrap.php';

/**
 * LogreaderPlugin.class.php
 *
 * ...
 *
 * @author  Florian Bieringer <florian.bieringer@uni-passau.de>
 * @version 0.1a
 */
class LogreaderPlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();

        // Only root can see this
        if ($GLOBALS['perm']->have_perm('root')) {
            $navigation = new AutoNavigation(_('LogReader'));
            $navigation->setURL(PluginEngine::GetURL($this));
            Navigation::addItem('/admin/logreaderplugin', $navigation);
        }
    }

    public function initialize() {
        
    }

    public function perform($unconsumed_path) {
        
        // https://www.youtube.com/watch?v=V4UfAL9f74I
        $GLOBALS['perm']->check('root');
        
        PageLayout::addScript($this->getPluginURL() . '/assets/application.js');
        PageLayout::addStylesheet($this->getPluginURL() . '/assets/style.css');
        $this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
                $this->getPluginPath(), rtrim(PluginEngine::getLink($this, array(), null), '/'), 'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }

}
