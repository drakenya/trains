<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 5/2/18
 * Time: 4:23 PM
 */

namespace App\LegacyIndustry\Loader;


use App\Entity\LegacyIndustry;
use Doctrine\ORM\EntityManagerInterface;

class Clearer
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function clear()
    {
        $connection = $this->manager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeUpdate(
            $platform->getTruncateTableSQL(
                $this->manager->getClassMetadata(LegacyIndustry::class)->getTableName()
            )
        );
    }
}