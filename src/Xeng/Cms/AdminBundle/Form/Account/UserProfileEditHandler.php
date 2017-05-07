<?php

// src/Xeng/Cms/AdminBundle/Form/Account/UserProfileEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Account;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Account\Profile;
use Xeng\Cms\CoreBundle\Entity\Auth\XUser;
use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit profile form handler
 */
class UserProfileEditHandler extends FormHandler {
    /** @var XUser $user */
    protected $user;

    /** @var Profile $profile */
    protected $profile;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param Profile $profile
     */
    public function __construct(ContainerInterface $container, Request $request, Profile $profile) {
        parent::__construct($container,$request);
        $this->profile=$profile;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $newProfile=($this->profile->getId()<0);
        $isSubmitted=$this->isSubmitted();

        if($newProfile && !$isSubmitted){
            return;
        }

        $firstName=$this->createParamValidationResult('firstName');
        $lastName=$this->createParamValidationResult('lastName');
        $profilePicture=$this->createFileParamValidationResult('profileImage');

        if($isSubmitted){
            if(!$profilePicture->isEmpty()) {
                $mimeWhiteListValidator = v::in([
                    'image/bmp',
                    'image/gif',
                    'image/jpg',
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                ]);
                $extensionWhiteListValidator = v::in([
                    'png',
                    'jpeg',
                    'jpg',
                    'bmp',
                    'gif'
                ]);
                $imageExtension = $profilePicture->getValue()->getClientOriginalExtension();
                $imageMimeType = $profilePicture->getValue()->getMimeType();

                if (!$mimeWhiteListValidator->validate($imageMimeType)) {
                    $this->addError($profilePicture, 'Profile image mime type not valid: ' . $imageMimeType);
                    return;
                }
                if (!$extensionWhiteListValidator->validate($imageExtension)) {
                    $this->addError($profilePicture, 'Profile image extension not valid: ' . $imageExtension);
                    return;
                }
            }

        } else if(!$isSubmitted && !$newProfile){
            $firstName->setValue($this->profile->getFirstName());
            $lastName->setValue($this->profile->getLastName());
            return;
        }

    }

}