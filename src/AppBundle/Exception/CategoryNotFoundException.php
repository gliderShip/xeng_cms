<?php
/**
 * Created by PhpStorm.
 * User: erinhima
 * Date: 1/25/2018
 * Time: 10:15
 */

namespace AppBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CategoryNotFoundException extends NotFoundHttpException
{
    /**
     * @param string     $category  The category name
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($category = null, \Exception $previous = null, $code = 0)
    {
        $message = "Category $category Not Found!!!";
        parent::__construct($message, $previous, $code);
    }
}
