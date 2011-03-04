<?php

class Spicylib_Controller_Action_Helper_Navigation extends Zend_Controller_Action_Helper_Abstract
{

    protected $_container;

    // constructor, set navigation container
    public function __construct(Zend_Navigation $container = null) {
        if (null !== $container) {
            $this->_container = $container;
        }
    }

    // check current request and set active page
    public function preDispatch() {
        $this->getContainer()
                        ->findBy('uri', $this->getRequest()->getRequestUri())
                ->active = true;
    }

    // retrieve navigation container
    public function getContainer() {
        if (null === $this->_container) {
            $this->_container = Zend_Registry::get('Zend_Navigation');
        }
        if (null === $this->_container) {
            throw new RuntimeException('Navigation container unavailable');
        }
        return $this->_container;
    }

    public function LoggedInfo()
    {
        die('LoggedInfo');
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
        {
            $username = $auth->getIdentity()->username;
            $logoutUrl = $this->view->url(array('controller' => 'auth',
                        'action' => 'logout'), null, true);
            return 'Welcome: <b><span style="color:red">'.$username.'</span></b> | My test account | '.' | '.'<a href="' . $logoutUrl . '">Logout</a>';
        }
    }
}
