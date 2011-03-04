<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //$this->_redirect('user');
        $auth = Zend_Auth::getInstance();
	if (!$auth->hasIdentity())
        $this->_redirect('auth');
    }

    public function indexAction()
    {
        // action body
    }


    public function addAction()
    {
        // action body
    }


}



