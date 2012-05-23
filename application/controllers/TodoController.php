<?php

class TodoController extends Zend_Controller_Action
{

    /**
     * @var Doctrine\ORM\EntityManager
     *
     *
     */
    protected $_em = null;

    public function init()
    {
        $this->_em = Zend_Registry::get('em');
    }

    public function saveAction()
    {
        if ($this->getRequest()->isPost() && ($this->getRequest()->getParam('id') != '')) {
            $addTodoForm = new Application_Form_Todo();

            if ($addTodoForm->isValid($this->getRequest()->getParams())) {
                $todo = $this->_em->getRepository("\TodoApp\Entity\Todo")->find($this->getRequest()->getParam('id'));

                $todo->setName($addTodoForm->getValue('name'));

                try {
                    $this->_em->persist($todo);
                    $this->_em->flush();
                } catch (Exception $e) {
                    $this->_helper->json(array(
                        'success'   => false,
                        'error' => $e->getMessage()
                    ));
                    return;
                }
            }

            $this->_helper->json(array(
                'success'   => true
            ));
        }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') != '') {
            $todo = $this->_em->getRepository("\TodoApp\Entity\Todo")->find($this->getRequest()->getParam('id'));

            try {
                $this->_em->remove($todo);
                $this->_em->flush();
            } catch (Exception $e) {
                $this->_helper->json(array(
                    'success'   => false,
                    'error' => $e->getMessage()
                ));
                return;
            }

            $this->_helper->json(array(
                'success'   => true
            ));
        }
    }

    public function addAction()
    {
        $return = array();

        if ($this->getRequest()->isPost()) {
            $addTodoForm = new Application_Form_Todo();

            if ($addTodoForm->isValid($this->getRequest()->getParams())) {
                $maxPosition = $this->_em->createQuery("SELECT MAX(position)+1 AS maxPosition FROM todo")->getResult();
                $position = 1;
                if ($maxPosition) {
                    $position = $position->maxPosition;
                }

                $values = $addTodoForm->getValues();
                $newTodo = new \TodoApp\Entity\Todo();
                $newTodo->setName($values['name']);
                $newTodo->setPosition($position);

                try {
                    $this->_em->persist($newTodo);
                    $this->_em->flush();
                } catch (Exception $e) {
                    $this->_helper->json(array(
                        'success'   => false,
                        'error' => $e->getMessage()
                    ));
                    return;
                }

                $this->_helper->json(array(
                    'success'   => true,
                    'id'  => $newTodo->getId(),
                    'name'  => $newTodo->getName()
                ));
                return;
            } else {
                $this->_helper->json(array(
                    'success'   => false,
                    'error' => $addTodoForm->getMessages()
                ));
                return;
            }
        }
    }

    public function rearrangeAction()
    {
        foreach ($this->getRequest()->getParam('positions') as $k => $id) {
            $todo = $this->_em->getRepository("\TodoApp\Entity\Todo")->find($id);
            $todo->setPosition($k);
            try {
                $this->_em->persist($todo);
            } catch (Exception $e) {
                throw $e;
                $this->_helper->json(array(
                    'success'   => false,
                    'error' => $e->getMessage()
                ));
                return;
            }
        }

        try {
            $this->_em->flush();
        } catch (Exception $e) {
            throw $e;
        }

        $this->_helper->json(array(
            'success'   => true
        ));
        return;
    }
}

