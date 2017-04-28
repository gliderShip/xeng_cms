<?php

// src/Xeng/Cms/CoreBundle/Repository/Account/ProfileRepository.php

namespace Xeng\Cms\CoreBundle\Repository\Account;

use Doctrine\ORM\EntityRepository;
use Xeng\Cms\CoreBundle\Entity\Account\Profile;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class ProfileRepository extends EntityRepository {

    /**
     * @param int $profileId
     * @return Profile
     */
    public function getProfile($profileId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from('XengCmsCoreBundle:Account\Profile','p');
        $qb->where('p.id = :profileId');
        $qb->setParameter('profileId', $profileId);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $userId
     * @return Profile
     */
    public function getProfileByUser($userId){
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from('XengCmsCoreBundle:Account\Profile','p');
        $qb->where('p.user = :userId');
        $qb->setParameter('userId', $userId);

        return $qb->getQuery()->getOneOrNullResult();
    }

}