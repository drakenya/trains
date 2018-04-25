<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:25 AM
 */

namespace App\LegacyIndustry\Cleaner;


interface CleanerInterface
{
    public function clean(?string $data): ?string;
}