<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 2:08 PM
 */

namespace App\LegacyIndustry\Translation;


class TranslationNotFoundException extends \Exception
{
    public function __construct(string $dataType, string $value)
    {
        $message = sprintf("Could not find translation for '%s' for data type '%s'", $value, $dataType);
        parent::__construct($message);
    }
}