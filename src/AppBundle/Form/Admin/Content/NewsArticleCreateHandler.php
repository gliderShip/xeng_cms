<?php

namespace AppBundle\Form\Admin\Content;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Base\FormHandler;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create news article form handler
 */
class NewsArticleCreateHandler extends FormHandler {

    /**
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct(ContainerInterface $container, Request $request) {
        parent::__construct($container,$request);
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        if(!$this->isSubmitted()){
            return;
        }

        $title=$this->createParamValidationResult('title');
        $this->createParamValidationResult('summary');
        $this->createParamValidationResult('body');

        if(!$this->notEmpty->validate($title->getValue())){
            $this->addError($title,'Title must not be empty');
            return;
        }

    }

}
