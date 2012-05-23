<?php

namespace TodoApp\Repository;

use Doctrine\ORM\EntityRepository;

class Todo extends EntityRepository
{
    /**
     * @return array
     */
    public function findThemAll()
    {
        $statement = 'SELECT t FROM TodoApp\Entity\Todo t ORDER BY t._position ASC';
        return $this->_em->createQuery($statement)->getResult();
    }
}
