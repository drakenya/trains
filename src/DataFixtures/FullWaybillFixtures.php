<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\CarCard;
use App\Entity\FullWaybill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class FullWaybillFixtures extends Fixture implements DependentFixtureInterface
{
    private const FIXTURES_TO_GENERATE = 13;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $fullWaybill = (new FullWaybill())
                ->setCarCard($this->getReference(sprintf('%s-%s', CarCardFixtures::REFERENCE, rand(1, CarCardFixtures::FIXTURES_TO_GENERATE))))
                ->setWaybill($this->getReference(sprintf('%s-%s', WaybillFixtures::REFERENCE, rand(1, WaybillFixtures::FIXTURES_TO_GENERATE))))

            ;
            $manager->persist($fullWaybill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CarCardFixtures::class,
            WaybillFixtures::class,
        ];
    }
}