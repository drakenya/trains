<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:27 AM
 */

namespace App\LegacyIndustry;


use App\Entity\LegacyIndustry;
use App\LegacyIndustry\Cleaner\EraCleaner;
use App\LegacyIndustry\Cleaner\StateCleaner;

class Creator
{
    private $eraCleaner;
    private $stateCleaner;

    public function __construct(
        EraCleaner $eraCleaner,
        StateCleaner $stateCleaner
    ) {
        $this->eraCleaner = $eraCleaner;
        $this->stateCleaner = $stateCleaner;
    }

    public function create(array $data): LegacyIndustry
    {
        $record = (new LegacyIndustry())
            ->setEra($this->eraCleaner->clean($data[0]))
            ->setName($data[1])
            ->setCity($data[2])
            ->setState($this->stateCleaner->clean($data[3]))
            ->setReportingMarks($data[4])
            ->setShipReceive($data[5])
            ->setCommodity($data[6])
            ->setStcc($data[7])
            ->setReciprocal($data[8])
            ->setSource($data[9])
        ;

        return $record;
    }
}