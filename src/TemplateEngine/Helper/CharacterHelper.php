<?php
/**
 * Created by PhpStorm.
 * User: argshub
 * Date: 9/14/2017
 * Time: 9:46 AM
 */

namespace TemplateEngine\Helper;


class CharacterHelper
{
    private function __construct()
    {
    }

    public static function removeCharacterFromRight(string $removeFor, string $characterToRemove): string {
        return rtrim($removeFor, $characterToRemove);
    }

    public static function removeCharacterFromBothSide(string $removeFor, string $characterToRemove): string {
        return ltrim(rtrim($removeFor, $characterToRemove), $characterToRemove);
    }

    public static function removeCharacterFromLeftSide(string $removeFor, string $characterToRemove): string {
        return ltrim($removeFor, $characterToRemove);
    }
}