<?php

class LoginController extends Zend_Controller_Action
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em = null;

    public function init()
    {
        $this->_em = Zend_Registry::get('em');
    }

    public function indexAction()
    {
        $this->view->form = $this->_getForm();
    }

    public function processAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index');
        }

        $form = $this->_getForm();
        if (!$form->isValid($this->getRequest()->getParams())) {
            $this->view->form = $form;
            return $this->render('index');
        }

        $adapter = $this->_getAuthAdapter($form->getValues());
        $result = Zend_Auth::getInstance()->authenticate($adapter);
        if (!$result->isValid()) {
            $this->view->errorString = 'Invalid credentials provided';
            $this->view->form = $form;
            return $this->render('index');
        }

        $this->_helper->redirector('index','index');
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index');
    }

    /**
     * @param array $values
     * @return Zend_Auth_Adapter_Interface
     */
    protected function _getAuthAdapter($values)
    {
        $adapter = new TodoApp_Auth_Adapter_Doctrine($this->_em, '\TodoApp\Entity\User', 'username', 'password');
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
        return $adapter;
    }

    protected function _getForm()
    {
        return new Application_Form_Login(array(
            'action'    => $this->view->baseUrl('/login/process'),
            'method'    => Zend_Form::METHOD_POST
        ));
    }
}