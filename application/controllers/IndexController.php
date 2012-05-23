<?php

class IndexController extends Zend_Controller_Action
{
    public function preDispatch()
    {
        if (!Zend_Auth::getInstance()->hasIdentity() && ($this->getRequest()->getActionName() != 'header') &&
                ($this->getRequest()->getActionName() != 'footer'))
        {
            $this->_helper->redirector('index','login');
        }
    }

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
        $todos = $this->_em->getRepository("\TodoApp\Entity\Todo")->findThemAll();
        $this->view->todos = $todos;
    }

    public function headerAction()
    {
        // action body
    }

    public function footerAction()
    {
        // action body
    }
}