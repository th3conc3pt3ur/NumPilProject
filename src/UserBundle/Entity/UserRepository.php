<?php

namespace UserBundle\Entity;


/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findPiloteDispo(){

        $qb = $this->_em->createQuery("SELECT u FROM UserBundle:User u WHERE NOT EXISTS (SELECT v FROM MainBundle:Vol v where v.pilote = u.id)  AND u.pilote = 1");
        $pilotes = $qb->getResult();
        return $pilotes;
    }
}
