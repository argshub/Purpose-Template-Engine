<?php

/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/12/2017
 * Time: 3:08 PM
 */

namespace TemplateEngine;

use TemplateEngine\Manager\ViewManager;
use TemplateEngine\Exceptions\PathNotDefined;
use TemplateEngine\Helper\CharacterHelper;
use TemplateEngine\PathProcess\ViewPathProcessor;


abstract class PurposeTemplateEngine
{
    protected $path;

    public function view(string $fileSource, ...$data) {
        if(!$this->path) throw new PathNotDefined("path not defined, define a path property with full path specification");
        $this->processPathAndDirectory();
        $file = $fileSource;
        if($this->isCache($file)) {
            foreach ($data as $datum)
                foreach ((array)$datum as $item => $value)
                    ${$item} = $value;
            require_once $fileSource;
        }
        else {
            foreach ($data as $datum)
                foreach ((array)$datum as $item => $value)
                    ${$item} = $value;
            $file = $this->compileAndProcessViewData($fileSource);
            require_once $file;
        }
    }

    private function cacheView() {
        return null;
    }

    private function isCache(string &$fileSource) {
        ViewPathProcessor::processViewPath($fileSource);
        $file = $this->path.$fileSource;
        if(!file_exists($file)) return false;
        $file = sha1(filesize($file));
        $file = $this->path."cache\\".$file;
        if(file_exists($file)) {
            $fileSource = $file;
            return true;
        }
        return false;
    }

    private function compileAndProcessViewData(string $fileSource) {
        $views = new ViewManager();
        $views->processView($fileSource);
        return $this->writeAndViewTemplateData($fileSource, $views->viewData());
    }

    private function processPathAndDirectory() {
        $this->path = CharacterHelper::removeCharacterFromRight($this->path, "\\");
        $this->path .= "\\";
        ViewManager::setPath($this->path);
        if(!is_dir($this->path)) mkdir($this->path);
        if(!is_dir($this->path."cache")) mkdir($this->path."cache");
    }

    private function writeAndViewTemplateData(string $fileSource, string $viewData) {
        ViewPathProcessor::processViewPath($fileSource);
        $file = $this->path.$fileSource;
        $fileSource = sha1(filesize($file));
        $fileSource = $this->path."cache\\".$fileSource;
        file_put_contents($fileSource, $viewData);
        return $fileSource;
    }

}