<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:46 AM
 */

namespace App\LegacyIndustry\Translation;


use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class TranslationParser
{
    private $translations = [];

    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    private function loadTranslations(string $key)
    {
        $file = sprintf('%s/../config/legacy_industry_cleaner/%s_translation.yaml', $this->kernel->getRootDir(), $key);

        $translationData = Yaml::parseFile($file);

        $this->translations[$key] = [];
        if (empty($translationData)) {
            return;
        }

        array_walk($translationData, function ($item) use ($key) {
            if (isset($this->translations[$key][$item[0]])) {
                throw new TranslationKeyExistsException($key, $item[0]);
            }

            $this->translations[$key][$item[0]] = $item[1] ?? $item[0];
        });
    }

    public function canTranslate(string $key, string $value): bool
    {
        if (!isset($this->translations[$key])) {
            $this->loadTranslations($key);
        }

        return isset($this->translations[$key][$value]);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return string|array|null
     */
    public function translate(string $key, string $value)
    {
        if (!isset($this->translations[$key])) {
            $this->loadTranslations($key);
        }

        if (is_array($this->translations[$key][$value])) {
            array_walk($this->translations[$key][$value], function ($item) use ($key) {
                if (!isset($this->translations[$key][$item])) {
                    throw new TranslationNotFoundException($key, $item);
                }
            });
            return $this->translations[$key][$value];
//            return implode(';', $this->translations[$key][$value]);
        }

        return $this->translations[$key][$value];
    }
}