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

    public function clean(?string $data): ?array
    {
        $data = trim(strtolower($data));

        if (empty($data)) {
            return null;
        }

        if ($this->translationParser->canTranslate(static::TRANSLATION_KEY, $data)) {
            $translation =  $this->translationParser->translate(static::TRANSLATION_KEY, $data);
            if (empty($translation)) {
                return null;
            }

            return is_array($translation) ? $translation : [$translation];
        }

        $this->logInabilityToClean($data);

        return [$data];
    }
}