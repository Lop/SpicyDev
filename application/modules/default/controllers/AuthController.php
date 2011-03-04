<?php

class Default_AuthController extends Zend_Controller_Action
{
    protected $authen = '';
    public function init()
    {
        
        $this->_helper->layout->disableLayout();
    }

    public function indexAction()
    {       
        $form = new Application_Form_Auth_Login();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if ($form->isValid($request->getPost()))
            {
                if ($this->AuthProcess($form->getValues()))
                {
                    $this->_helper->layout->enableLayout();
                    $this->view->render('sidebar/_sidebar.phtml');
                    // if($this->authen = 'admin') die('aaaadmin');
                    //if($this->authen = 'user') die('aaaauser');
                    $this->_redirect('admin');
                }
                else
                {
                    echo "<script type='text/javascript'>window.alert('User name or Password is incorrected!')</script>";
                }
            }
        }
        $this->view->form = $form;
    }

    protected function AuthProcess($values)
    {
        $adapter = $this->getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid())
        {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            //die($user);
            //$authen = $values['role'];
            //die( $authen);
            return true;
        }
        return false;
    }

    protected function getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('users')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        return $authAdapter;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index'); // back to login page
    }
}

