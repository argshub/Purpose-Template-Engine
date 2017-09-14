<?php

/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/14/2017
 * Time: 12:15 PM
 */

namespace TemplateEngine\PathProcess;

use TemplateEngine\Helper\CharacterHelper;

class ViewPathProcessor
{
    private function __construct() {

    }

    static function processViewPath(string &$sourceOfFile) {
        $sourceOfFile = CharacterHelper::removeCharacterFromBothSide($sourceOfFile, ".");
        $sourceOfFile = CharacterHelper::removeCharacterFromBothSide($sourceOfFile, "\\");
        $sourceOfFile = str_replace(".", "\\", $sourceOfFile);
        $sourceOfFile .= ".ps.php";
    }
}