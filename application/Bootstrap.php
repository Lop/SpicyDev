<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initPlaceholders() {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        // Set the initial title and separator:
        $view->headTitle('SpicyCRM')
                ->setSeparator(' :: ');

        // Set the initial stylesheet:
        $view->headLink()->prependStylesheet('/css/spicy.css');
        $view->headLink()->appendStylesheet('/css/wideget.css');

        // Set the initial JS to load:
        $view->headScript()->prependFile('/js/jquery-1.4.4.min.js');
        $view->headScript()->appendFile('/js/jquery-ui-1.8.9.custom.min.js');

        // Set Leftsidebar
        $view->placeholder('sidebar')
                // "prefix" -> markup to emit once before all items in collection
                ->setPrefix("<div id=\"sidemenu\">\n    <div class=\"block\">\n")
                // "separator" -> markup to emit between items in a collection
                ->setSeparator("</div>\n    <div class=\"block\">\n")
                // "postfix" -> markup to emit once after all items in a collection
                ->setPostfix("</div>\n</div>");

        // Set header
    }

    protected function _initNavigation() {
        // read navigation XML and initialize container
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
        $container = new Zend_Navigation($config);

        // register navigation container
        $reistry = Zend_Registry::getInstance();
        $reistry->set('Zend_Navigation', $container);

        // add action helper
        Zend_Controller_Action_HelperBroker::addHelper(
                new Spicylib_Controller_Action_Helper_Navigation()
                );
//        Zend_Controller_Action_HelperBroker::addHelper(
//                new Spicylib_Controller_Action_Helper_LoggedInAs()
//                );
    }   

}

