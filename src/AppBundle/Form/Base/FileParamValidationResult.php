<?php

namespace AppBundle\Form\Base;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * This serves as the validation result object for a single field
 */
class FileParamValidationResult extends ParamValidationResult {

    /**
     * Wrapper for the value getter to "typecast" the value to UploadedFile
     * @return UploadedFile | null
     */
    public function getValue() {
        if($this->value!=null){
            return $this->value;
        } else {
            return null;
        }
    }

}
