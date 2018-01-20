<?php

namespace AppBundle\Form\Admin\Content;

use AppBundle\Form\Base\FormHandler;
use Respect\Validation\Validator as v;
use AppBundle\Services\Content\CategoryManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create category form handler
 */
class CategoryCreateHandler extends FormHandler {

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        if(!$this->isSubmitted()){
            return;
        }
        $name=$this->createParamValidationResult('name');
        $label=$this->createParamValidationResult('label');
        $this->createParamValidationResult('hidden');

        $nameValidator=v::allOf(
            $this->notEmpty,
            v::alnum('-_')
        );
        if(!$nameValidator->validate($name->getValue())){
            $this->addError($name,'Name not valid, must be alphanumeric');
            return;
        }

        if(!$this->notEmpty->validate($label->getValue())){
            $this->addError($label,'Label must not be empty');
            return;
        }

        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->container->get('xeng.category_manager');

        if($categoryManager->categoryNameExists($name->getValue())){
            $this->addError($name,'Category name already exists');
            return;
        }

    }
}
