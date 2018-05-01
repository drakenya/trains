<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:46 AM
 */

namespace App\LegacyIndustry\Translation;


use Symfony\Component\Yaml\Yaml;

class TranslationParser
{
    private $dataType;
    private $translations = [];

    public function __construct(string $dataType, string $translationFile)
    {
        $this->dataType = $dataType;
        $this->loadTranslations($translationFile);
    }

    private function loadTranslations(string $file)
    {
        $translationData = Yaml::parseFile($file);

        $this->translations = [];
        if (empty($translationData)) {
            return;
        }

        array_walk($translationData, function ($item) use ($file) {
            if (isset($this->translations[$item[0]])) {
                throw new TranslationKeyExistsException($this->dataType, $item[0]);
            }

            $this->translations[$item[0]] = $item[1] ?? $item[0];
        });
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function canTranslate(string $value): bool
    {
        return isset($this->translations[$value]);
    }

    /**
     * @param string $value
     *
     * @return string|array|null
     */
    public function translate(string $value)
    {
        if (is_array($this->translations[$value])) {
            array_walk($this->translations[$value], function ($item) {
                if (!isset($this->translations[$item])) {
                    throw new TranslationNotFoundException($this->dataType, $item);
                }
            });
            return $this->translations[$value];
        }

        return $this->translations[$value];
    }
}