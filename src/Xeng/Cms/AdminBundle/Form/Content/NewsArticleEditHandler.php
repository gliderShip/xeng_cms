<?php

// src/Xeng/Cms/AdminBundle/Form/Account/NewsArticleEditHandler.php

namespace Xeng\Cms\AdminBundle\Form\Content;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Xeng\Cms\CoreBundle\Entity\Content\NewsArticle;
use Xeng\Cms\CoreBundle\Form\FormHandler;
use Respect\Validation\Validator as v;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * create news article form handler
 */
class NewsArticleEditHandler extends FormHandler {
    /** @var  NewsArticle $article */
    protected $article;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param NewsArticle $article
     */
    public function __construct(ContainerInterface $container, Request $request,NewsArticle $article) {
        parent::__construct($container,$request);
        $this->article=$article;
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $title=$this->createParamValidationResult('title');
        $this->createParamValidationResult('summary');
        $this->createParamValidationResult('body');
        $image=$this->createFileParamValidationResult('image');

        if(!$this->isSubmitted()){
            $this->validationResponse->setValue('title',$this->article->getTitle());
            $this->validationResponse->setValue('summary',$this->article->getSummary());
            $this->validationResponse->setValue('body',$this->article->getBody());
            return;
        }

        if(!$image->isEmpty()) {
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

        if(!$this->notEmpty->validate($title->getValue())){
            $this->addError($title,'Title must not be empty');
            return;
        }

    }

}