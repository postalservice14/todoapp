<?php

class Application_Form_Todo extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->setAction($this->getView()->baseUrl('/todo/add'));
        $this->setAttrib('id','addTodo');

        $todo = new Zend_Form_Element_Text('name');

        $todo->setRequired(true);

        $this->addElements(array($todo));
    }
}