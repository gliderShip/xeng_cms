<?php

// src/Xeng/Cms/CoreBundle/Security/Voter/PermissionVoter.php

namespace Xeng\Cms\CoreBundle\Security\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Xeng\Cms\CoreBundle\Services\Auth\XUserManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class PermissionVoter implements VoterInterface {
    private $prefix;

    /** @var XUserManager $userManager */
    private $userManager;

    /**
     * Constructor.
     *
     * @param XUserManager $userManager
     * @param string $prefix The role prefix
     */
    public function __construct(XUserManager $userManager,$prefix = 'p[') {
        $this->userManager=$userManager;
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute) {
        return is_string($attribute) && 0 === strpos($attribute, $this->prefix);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class) {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes) {

        $user=$token->getUser();
        if($user === 'anon.'){
            return self::ACCESS_DENIED;
        }

        $legacyRoles = $token->getRoles();
        //if super admin access granted
        foreach ($legacyRoles as $legacyRole) {
            if ($legacyRole->getRole() === 'ROLE_SUPER_ADMIN') {
                return self::ACCESS_GRANTED;
            }
        }


        $userPermissionMap=$this->userManager->getUserPermissionMap($user->getId());
        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                return self::ACCESS_ABSTAIN;
            }

            $permission=substr($attribute, 2, -1);
            if ($userPermissionMap[$permission]) {
                return self::ACCESS_GRANTED;
            }

        }

        return self::ACCESS_DENIED;
    }

}
