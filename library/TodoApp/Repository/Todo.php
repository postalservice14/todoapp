<?php

namespace TodoApp\Repository;

use Doctrine\ORM\EntityRepository;

class Todo extends EntityRepository
{
    /**
     * @param int $userId
     * @return array
     */
    public function findThemAll($userId)
    {
        $statement = 'SELECT t FROM TodoApp\Entity\Todo t WHERE t._userId = '.$userId.' ORDER BY t._position ASC';
        return $this->_em->createQuery($statement)->getResult();
    }
}
