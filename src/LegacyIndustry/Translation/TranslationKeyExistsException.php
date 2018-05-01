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
    public function __construct(string $dataType, string $value)
    {
        $message = sprintf("Translation key already exists for '%s' in data type '%s'", $value, $dataType);
        parent::__construct($message);
    }
}