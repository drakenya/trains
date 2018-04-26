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
    public function __construct(string $key, string $value)
    {
        $message = sprintf("Could not find translation for '%s' in key space '%s'", $value, $key);
        parent::__construct($message);
    }
}