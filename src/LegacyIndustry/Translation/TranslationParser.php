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

        array_walk($translationData, function ($item) use ($key) {
            $this->translations[$key][$item[0]] = $item[1];
        });
    }

    public function canTranslate(string $key, string $value): bool
    {
        if (!isset($this->translations[$key])) {
            $this->loadTranslations($key);
        }

        return isset($this->translations[$key][$value]);
    }

    public function translate(string $key, string $value): ?string
    {
        if (!isset($this->translations[$key])) {
            $this->loadTranslations($key);
        }

        return $this->translations[$key][$value];
    }
}