<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/14/2017
 * Time: 11:28 AM
 */

namespace TemplateEngine\Manager;


use TemplateEngine\Compiler\PurposeCompiler;
use TemplateEngine\Exceptions\AttachmentNotFound;
use TemplateEngine\PathProcess\ViewPathProcessor;
use TemplateEngine\Exceptions\ViewFileNotExists;
use TemplateEngine\Helper\CharacterHelper;

class ViewManager
{
    private $compiler;

    private static $path;

    private static $attachment = array();
    private static $compileData = array();

    public function __construct()
    {
        $this->compiler = new PurposeCompiler(self::$path);
    }

    public static function getPath()
    {
        return self::$path;
    }

    public function processView(string $viewPath)
    {
        ViewPathProcessor::processViewPath($viewPath);
        $this->fileChecker($viewPath);
        $this->readFileData($viewPath);
    }

    public function processIncludesView(string $viewPath)
    {
        ViewPathProcessor::processViewPath($viewPath);
        $this->fileChecker($viewPath);
        return $this->includeData($viewPath);
    }

    public static function setPath(string $path)
    {
        self::$path = $path;
    }


    private function fileChecker(string &$viewPath)
    {
        $viewPath = self::$path . $viewPath;
        if (!file_exists($viewPath)) throw new ViewFileNotExists("{$viewPath} named file not exists");
    }

    private function readFileData(string &$fileToRead)
    {
        $fileData = file($fileToRead);
        for ($i = 0; $i < count($fileData); $i++) {
            $data = CharacterHelper::removeCharacterFromBothSide($fileData[$i], " \r\n");
            if (strpos($data, "#template") !== false) {
                $data = preg_replace("/#template/", "", $data);
                $data = CharacterHelper::removeCharacterFromBothSide($data, "(");
                $data = CharacterHelper::removeCharacterFromBothSide($data, ")");
                $data = CharacterHelper::removeCharacterFromBothSide($data, "'\"");
                (new self())->processView($data);
            } elseif (strpos($data, "#attach") !== false) {
                $data = preg_replace("/#attach/", "", $data);
                $attachData = array();
                for ($k = $i + 1; $k < count($fileData); $k++) {
                    $attachment = CharacterHelper::removeCharacterFromBothSide($fileData[$k], " \r\n");
                    if ($attachment == "#stop") {
                        $i = $k;
                        break;
                    }
                    $attachData[] = $this->compiler->compileData($attachment);
                }
                $data = CharacterHelper::removeCharacterFromBothSide($data, "(");
                $data = CharacterHelper::removeCharacterFromBothSide($data, ")");
                $data = CharacterHelper::removeCharacterFromBothSide($data, "'");
                self::$attachment[$data] = $attachData;
            } elseif (strpos($data, "#capture") !== false) {
                $data = preg_replace("/#capture/", "", $data);
                $data = CharacterHelper::removeCharacterFromBothSide($data, "(");
                $data = CharacterHelper::removeCharacterFromBothSide($data, ")");
                $data = CharacterHelper::removeCharacterFromBothSide($data, "'");
                self::$compileData[$data] = array();
            } else self::$compileData[] = $this->compiler->compileData($data);
        }
    }

    public function viewData(): string
    {
        $this->checkAttachment();
        return $this->finalViewData();
    }

    private function includeData(string $viewPath): string
    {
        $data = "";
        foreach (file($viewPath) as $item) {
            $item = CharacterHelper::removeCharacterFromBothSide($item, " \r\n");
            $data .= $this->compiler->compileData($item);
        }
        return $data;
    }

    private function checkAttachment()
    {
        foreach (self::$attachment as $item => $value) {
            if (!isset(self::$compileData[$item])) throw new AttachmentNotFound("{$item} attachment not found on template");
            self::$compileData[$item] = $value;
            unset(self::$attachment[$item]);
        }
    }

    private function finalViewData(): string
    {
        $data = "";
        foreach (self::$compileData as $compileDatum => $datum) {
            if (is_array($datum)) {
                foreach ($datum as $item) {
                    $data .= $item;
                }
            } else $data .= $datum;
        }
        return $data;
    }

}