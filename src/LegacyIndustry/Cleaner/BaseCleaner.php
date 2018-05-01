<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 9:35 AM
 */

namespace App\LegacyIndustry\Cleaner;


use App\LegacyIndustry\Translation\TranslationParser;
use Psr\Log\LoggerInterface;

abstract class BaseCleaner
{
    protected $translationParser;
    private $logger;

    public function __construct(TranslationParser $translationParser, LoggerInterface $logger)
    {
        $this->translationParser = $translationParser;
        $this->logger = $logger;
    }

    protected function logInabilityToClean(string $data)
    {
        $this->logger->debug('Cannot clean data', ['type' => $this->translationParser->getDataType(), 'data' => $data]);
    }
}