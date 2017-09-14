<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/12/2017
 * Time: 3:43 PM
 */

namespace TemplateEngine\Exceptions;


use Exception;

abstract class PurposeTemplateException extends \Exception
{
    function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    function getExceptionDetails(): string {
        return "Message Type: " . $this->getMessage() .
            "\nFile: " . $this->getFile() .
            "\nTrace: " . $this->getCode() .
            "\nLine: " . $this->getLine() .
            "\nTrace: " . $this->getTraceAsString();
    }
}