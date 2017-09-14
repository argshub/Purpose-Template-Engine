<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/14/2017
 * Time: 1:01 PM
 */

namespace TemplateEngine\Compiler;


use TemplateEngine\Helper\CharacterHelper;
use TemplateEngine\Manager\ViewManager;
use TemplateEngine\PathProcess\ViewPathProcessor;

class PurposeCompiler
{
    function __construct() {

    }

    function compileData(string $item) {
        $data = "";
        if (strpos($item, "{{") !== false) {
            $data = preg_replace("/{{/", "<?= ", $item);
            $data = preg_replace("/}}/", " ?>", $data);
        }
        elseif (strpos($item, "#endif") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= "; ?>";
        }
        elseif (strpos($item, "#elseif") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= ": ?>";
        }
        elseif (strpos($item, "#else") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= ": ?>";
        }
        elseif (strpos($item, "#if") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= ": ?>";
        }
        elseif (strpos($item, "#endforeach") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= "; ?>";
        }
        elseif (strpos($item, "#foreach") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= ": ?>";
        }
        elseif (strpos($item, "#endfor") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= "; ?>";
        }
        elseif (strpos($item, "#for") !== false) {
            $data = preg_replace("/#/", "<?php ", $item);
            $data .= ": ?>";
        } elseif (strpos($item, "#include") !== false) {
            $includeData = preg_replace("/#include/", "", $item);;
            $includeData = CharacterHelper::removeCharacterFromBothSide($includeData, "(");
            $includeData = CharacterHelper::removeCharacterFromBothSide($includeData, ")");
            $includeData = CharacterHelper::removeCharacterFromBothSide($includeData, "'\"");
            return (new ViewManager())->processIncludesView($includeData);
        }
        else $data = $item;
        return $data;
    }

}