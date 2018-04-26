<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:24 AM
 */

namespace App\LegacyIndustry\Cleaner;


class CommodityCleaner extends BaseCleaner
{
    protected const TRANSLATION_KEY = 'commodity';

    public function clean(?string $data): ?string
    {
        $data = trim(strtolower($data));

        if (empty($data)) {
            return null;
        }

        if ($this->translationParser->canTranslate(static::TRANSLATION_KEY, $data)) {
            return $this->translationParser->translate(static::TRANSLATION_KEY, $data);
        }

        $this->logInabilityToClean($data);

        return $data;
    }
}