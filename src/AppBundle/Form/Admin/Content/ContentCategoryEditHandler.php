<?php

namespace AppBundle\Form\Admin\Content;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Content\Category;
use AppBundle\Entity\Content\ContentNode;
use AppBundle\Form\Base\FormHandler;
use AppBundle\Services\Content\ContentManager;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * edit content category relation
 */
class ContentCategoryEditHandler extends FormHandler {
    /** @var ContentNode $node */
    protected $node;

    /** @var array $categories */
    protected $categories;

    /** @var array $toBeDeleted */
    protected $toBeDeleted;

    /** @var array $toBeAdded */
    protected $toBeAdded;

    /** @var ContentManager $contentManager */
    protected $contentManager;

    /**
     * @param ContainerInterface $container
     * @param Request $request
     * @param ContentNode $node
     * @param array $categories
     * @param ContentManager $contentManager
     */
    public function __construct(ContainerInterface $container, Request $request, ContentNode $node, $categories, ContentManager $contentManager) {
        parent::__construct($container,$request);

        $this->contentManager = $contentManager;
        $this->node=$node;
        $this->categories=$categories;
        $this->toBeAdded=array();
        $this->toBeDeleted=array();
    }

    /**
     * Implement this method
     * It should contain all form parameter read and validation logic
     */
    public function handle(){
        parent::handle();

        $contentCategoryMap=$this->contentManager->getContentCategoryMap($this->node->getId());

        if($this->isSubmitted()){
            /** @var Category $category */
            foreach($this->categories as $category){
                $key='category_'.$category->getId();

                $param=$this->createParamValidationResult($key);

                $alreadyExists=array_key_exists($key,$contentCategoryMap);
                $isEmpty=$param->isEmpty();
                //if it is empty but it exists on db, delete it
                if($isEmpty && $alreadyExists){
                    $this->toBeDeleted[]=$contentCategoryMap[$key];
                }
                //else if it is not empty but not exists on db, add it
                elseif(!$isEmpty && !$alreadyExists){
                    $this->toBeAdded[]=$category;
                }
            }
        } else {
            //it is not submitted yet, just fill in the values according to the existing saved values
            foreach($contentCategoryMap as $ccKey=>$cc){
                $this->createParamValidationResult($ccKey)->setValue('on')->setEmpty(false);
            }
        }

    }

    /**
     * @return array
     */
    public function getToBeDeleted(){
        return $this->toBeDeleted;
    }

    /**
     * @return array
     */
    public function getToBeAdded(){
        return $this->toBeAdded;
    }

}
