<?php

namespace TodoApp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TodoApp\Repository\Todo")
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private $_id;

    /**
     * @ORM\Column(type="integer", name="username")
     * @var int
     */
    private $_username;

    /**
     * @ORM\Column(type="string", name="password")
     * @var string
     */
    private $_password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param int $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return int
     */
    public function getUsername()
    {
        return $this->_username;
    }
}
