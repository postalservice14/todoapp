<?php

namespace TodoApp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TodoApp\Repository\Todo")
 * @ORM\Table(name="todo")
 */
class Todo
{
    /**
     * @ORM\Id @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $_id;

    /**
     * @ORM\Column(type="integer", name="position")
     */
    private $_position;

    /**
     * @ORM\Column(type="string", name="name")
     * @var string
     */
    private $_name;

    /**
     * @ORM\Column(type="datetime", name="create_ts")
     * @var \Zend_Date
     */
    private $_createTs;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return \Zend_Date
     */
    public function getCreateTs()
    {
        return new \Zend_Date($this->_createTs, \Zend_Date::ISO_8601);
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->_position = $position;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->_position;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
}
