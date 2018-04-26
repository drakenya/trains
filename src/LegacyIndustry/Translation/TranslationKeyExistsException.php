<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 2:08 PM
 */

namespace App\LegacyIndustry\Translation;


class TranslationKeyExistsException extends \Exception
{
    public function __construct(string $key, string $value)
    {
        $message = sprintf("Translation key already exists for '%s' in key space '%s'", $value, $key);
        parent::__construct($message);
    }
}