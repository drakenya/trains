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
    public function clean(?string $data): ?int
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
                return (int) $data;
            }

            if (strlen($data) === 2 && $data > date('y')) {
                return (int) ('19' . $data);
            }

            return (int) ('20' . $data);
        }

        if ($this->translationParser->canTranslate($data)) {
            return (int) $this->translationParser->translate($data);
        }

        $this->logInabilityToClean($data);

        return (int) $data;
    }
}