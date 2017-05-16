<?php

// src/Xeng/Cms/AdminBundle/Form/Content/ContentImageUploadHandler.php

namespace Xeng\Cms\AdminBundle\Form\Content;

use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create news article form handler
 */
class ContentImageUploadHandler extends FormHandler {

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $image=$this->createFileParamValidationResult('image');

        if(!$this->isSubmitted()){
            return;
        }
        if($image->isEmpty()) {
            $this->addError($image, 'No image to upload');
            return;
        } else {
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
            $imageExtension = $image->getValue()->getClientOriginalExtension();
            $imageMimeType = $image->getValue()->getMimeType();

            if (!$mimeWhiteListValidator->validate($imageMimeType)) {
                $this->addError($image, 'Image mime type not valid: ' . $imageMimeType);
                return;
            }
            if (!$extensionWhiteListValidator->validate($imageExtension)) {
                $this->addError($image, 'Image extension not valid: ' . $imageExtension);
                return;
            }
        }

    }

}