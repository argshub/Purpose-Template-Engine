<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/12/2017
 * Time: 3:46 PM
 */

namespace TemplateEngine\Exceptions;


use Exception;

class PathNotDefined extends PurposeTemplateException
{
    function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}