<?php

namespace AppBundle\Repository\Account;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Account\Profile;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ProfileRepository extends EntityRepository {

    /**
     * @param int $profileId
     * @return Profile
     * @throws NonUniqueResultException
     */
    public function getProfile($profileId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from('AppBundle:Account\Profile','p');
        $qb->where('p.id = :profileId');
        $qb->setParameter('profileId', $profileId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $userId
     * @return Profile
     * @throws NonUniqueResultException
     */
    public function getProfileByUser($userId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from('AppBundle:Account\Profile','p');
        $qb->where('p.user = :userId');
        $qb->setParameter('userId', $userId);

        return $qb->getQuery()->getOneOrNullResult();
    }

}
