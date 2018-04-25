<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:24 AM
 */

namespace App\LegacyIndustry\Cleaner;


class EraCleaner extends BaseCleaner
{
    protected const TRANSLATION_KEY = 'era';

    public function clean(?string $data): ?string
    {
        $data = trim($data);

        if (empty($data)) {
            return null;
        }

        if (preg_match('/^\d{2}\-\d{2}$/', $data) || preg_match("/^\d{2}'?s$/", $data)) {
            $data = substr($data, 0, 2);
        } elseif (preg_match("/^'\d{4}$/", $data) || preg_match('/^>\d{2}$/', $data)) {
            $data = substr($data, 1);
        }

        if (is_numeric($data)) {
            if (strlen($data) === 4) {
                return $data;
            }

            if (strlen($data) === 2 && $data > date('y')) {
                return '19' . $data;
            }

            return '20' . $data;
        }

        if ($this->translationParser->canTranslate(static::TRANSLATION_KEY, $data)) {
            return $this->translationParser->translate(static::TRANSLATION_KEY, $data);
        }

        $this->logInabilityToClean($data);

        return $data;
    }
}