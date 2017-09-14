<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/14/2017
 * Time: 12:27 PM
 */

namespace TemplateEngine\Exceptions;


use Exception;

class ViewFileNotExists extends PurposeTemplateException
{
    function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}