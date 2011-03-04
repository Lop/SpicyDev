<?php

class User_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
        $this->_helper->layout->disableLayout();
    }

    public function indexAction()
    {
        $form = new Application_Form_User_AddNewUser();
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if ($form->isValid($request->getPost()))
            {
                $values = $form->getValues();
                if($this->validate_user($values))
                {
                    $this->AddNewUser($values);
                    $this->_redirect('auth');
                }
            }
        }
        $this->view->form = $form;
    }

//    public function AddNewUser($user_name, $password, $role)
//    {
//       $db = Zend_Db_Table::getDefaultAdapter();
//       $salt = $this->GetSaltCode();
//       $sha1_password = sha1($password.$salt);
//       $db->insert('users',
//               array('username' => $user_name,
//                   'password' => $sha1_password,
//                   'salt' => $salt,
//                   'role' => $role)
//               );
//    }

    public function AddNewUser($values)
    {
       $db = Zend_Db_Table::getDefaultAdapter();
       $salt = $this->GetSaltCode();
       $sha1_password = sha1($values['password'].$salt);
       $db->insert('users',
               array('username' => $values['username'],
                   'password' => $sha1_password,
                   'salt' => $salt,
                   'role' => $values['role'])
               );
    }

    private function GetSaltCode($digit = 40)
    {
        $salt_out = null;
        for($x=0;$x<$digit;$x++)
        {
            $salt_out .= dechex(rand(0, 15));
        }
        return $salt_out;
    }

    public function validate_user($user_values)
    {
        //if($user_values['username']!=
        if(strcmp($user_values['password'],$user_values['confirm_pass'])==0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}

