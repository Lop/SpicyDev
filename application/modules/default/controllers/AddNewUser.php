<?php

class Default_AddNewUserController extends Zend_Controller_Action
{
    public function init()
    {
//        $auth = Zend_Auth::getInstance();
//	if (!$auth->hasIdentity())
//        $this->_redirect('auth');
    }

    public function indexAction()
    {
        $this->_helper->layout->disableLayout();
        $form = new Application_Form_AddUser_adduser();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if ($form->isValid($request->getPost()))
            {
                $this->view->form = $form;
            }
        }
    }
}