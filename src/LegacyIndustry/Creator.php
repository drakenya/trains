<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:27 AM
 */

namespace App\LegacyIndustry;


use App\Entity\LegacyIndustry;
use App\LegacyIndustry\Cleaner\CommodityCleaner;
use App\LegacyIndustry\Cleaner\EraCleaner;
use App\LegacyIndustry\Cleaner\StateCleaner;

class Creator
{
    private $eraCleaner;
    private $stateCleaner;
    private $commodityCleaner;

    public function __construct(
        EraCleaner $eraCleaner,
        StateCleaner $stateCleaner,
        CommodityCleaner $commodityCleaner
    ) {
        $this->eraCleaner = $eraCleaner;
        $this->stateCleaner = $stateCleaner;
        $this->commodityCleaner = $commodityCleaner;
    }

    public function create(array $data): LegacyIndustry
    {
        $commodity = $this->commodityCleaner->clean($data[6]);
        if (is_array($commodity)) {
            $commodity = implode(';', $commodity);
        }

        $record = (new LegacyIndustry())
            ->setEra($this->eraCleaner->clean($data[0]))
            ->setName($data[1])
            ->setCity($data[2])
            ->setState($this->stateCleaner->clean($data[3]))
            ->setReportingMarks($data[4])
            ->setShipReceive($data[5])
            ->setCommodity($commodity)
            ->setStcc($data[7])
            ->setReciprocal($data[8])
            ->setSource($data[9])
        ;

        return $record;
    }
}