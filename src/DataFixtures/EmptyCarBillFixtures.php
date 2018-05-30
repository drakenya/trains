<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\EmptyCarBill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class EmptyCarBillFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'empty-car-card';
    public const FIXTURES_TO_GENERATE = 13;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $location1 = rand(1, LocationFixtures::FIXTURES_TO_GENERATE);
            $location2 = ($location1 % LocationFixtures::FIXTURES_TO_GENERATE) + 1;

            $emptyCarBill = new EmptyCarBill();

            if (rand(1, 2) === 1) {
                $emptyCarBill
                    ->setHomeBilledFrom($this->getReference(sprintf('%s-%s', LocationFixtures::REFERENCE, $location1)))
                    ->setHomeToOrVia($this->faker->regexify('([A-Z]{2,3}-){5,8}[A-Z]{2,3}'))
                ;
            } else {
                if (rand(1, 2) === 1) {
                    $emptyCarBill
                        ->setLoadingBilledFrom($this->getReference(sprintf('%s-%s', LocationFixtures::REFERENCE, $location1)))
                        ->setLoadingTo($this->getReference(sprintf('%s-%s', LocationFixtures::REFERENCE, $location2)))
                    ;
                } else {
                    $emptyCarBill
                        ->setLoadingBilledFrom($this->getReference(sprintf('%s-%s', LocationFixtures::REFERENCE, $location1)))
                        ->setLoadingShipper($this->getReference(sprintf('%s-%s', CustomerFixtures::REFERENCE, rand(1, CustomerFixtures::FIXTURES_TO_GENERATE))))
                        ->setLoadingSpot(sprintf('%s.%s', $this->faker->randomNumber(1), $this->faker->randomNumber(3)))
                    ;
                }
            }

            $manager->persist($emptyCarBill);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $emptyCarBill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            LocationFixtures::class,
        ];
    }
}