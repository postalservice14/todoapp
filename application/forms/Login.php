<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $username = $this->addElement('text','username', array(
            'filters'   => array('StringTrim','StringToLower'),
            'validators'    => array(
                'Alpha',
                array('StringLength', false, array(3, 20))
            ),
            'required'  => true,
            'label'     => 'Username:'
        ));

        $password = $this->addElement('password','password', array(
            'filters'   => array('StringTrim'),
            'validators'    => array(
                'Alnum',
                array('StringLength', false, array(4, 20))
            ),
            'required'  => true,
            'label' => 'Password:'
        ));

        $loginButton = $this->addElement('submit','login',array(
            'required'  => false,
            'ignore'    => true,
            'label'     => 'Login'
        ));
    }


}

