<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\FullEmptyCarBill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FullEmptyCarBillFixtures extends Fixture implements DependentFixtureInterface
{
    private const FIXTURES_TO_GENERATE = 13;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $fullEmptyCarBill = (new FullEmptyCarBill())
                ->setCarCard($this->getReference(sprintf('%s-%s', CarCardFixtures::REFERENCE, rand(1, CarCardFixtures::FIXTURES_TO_GENERATE))))
                ->setEmptyCarBill($this->getReference(sprintf('%s-%s', EmptyCarBillFixtures::REFERENCE, rand(1, EmptyCarBillFixtures::FIXTURES_TO_GENERATE))))

            ;
            $manager->persist($fullEmptyCarBill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CarCardFixtures::class,
            EmptyCarBillFixtures::class,
        ];
    }
}