<?php

namespace AppBundle\Form\Admin\Content;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Content\Category;
use AppBundle\Form\Base\FormHandler;
use Respect\Validation\Validator as v;
use AppBundle\Services\Content\CategoryManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit category form handler
 */
class CategoryEditHandler extends FormHandler {
    /** @var Category $category */
    protected $category;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param Category $category
     */
    public function __construct(ContainerInterface $container, Request $request, Category $category) {
        parent::__construct($container,$request);
        $this->category=$category;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $name=$this->createParamValidationResult('name');
        $label=$this->createParamValidationResult('label');
        $this->createParamValidationResult('hidden');

        if(!$this->isSubmitted()){
            $this->validationResponse->setValue('name',$this->category->getName());
            $this->validationResponse->setValue('label',$this->category->getLabel());
            $this->validationResponse->setValue('hidden',$this->category->isHidden());

            return;
        }

        $nameValidator=v::allOf(
            $this->notEmpty,
            v::alnum('-_')
        );
        if(!$nameValidator->validate($name->getValue())){
            $this->addError($name,'Role name not valid, must me alphanumeric');
            return;
        }
        if(!$this->notEmpty->validate($label->getValue())){
            $this->addError($label,'Label must not be empty');
            return;
        }

        /** @var CategoryManager $categoryManager */
        $categoryManager = $this->container->get('xeng.category_manager');

        $nameValue=$name->getStringValue();
        if($this->category->getName()!==$nameValue && $categoryManager->categoryNameExists($nameValue)){
            $this->addError($name,'Category name is already taken');
            return;
        }

    }

}
