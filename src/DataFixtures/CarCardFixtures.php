<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\CarCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CarCardFixtures extends Fixture
{
    public const CAR_CARD_REFERENCE = 'car-card';
    public const FIXTURES_TO_GENERATE = 43;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $carCard = (new CarCard())
                ->setReportingMark($faker->regexify('[A-Z]{1,2}&?[A-Z]'))
                ->setCarNumber($faker->numberBetween(1000, 999999))
                ->setAarType($faker->randomElement(['XM', 'XA', 'HT']))
                ->setLengthCapacity($faker->optional(0.80)->randomElement(["40'", "50'", "70t", "100t"]))
                ->setDescription($faker->optional(0.25)->words(2, true))
            ;
            $manager->persist($carCard);

            $this->addReference(sprintf('%s-%s', static::CAR_CARD_REFERENCE, ($i + 1)), $carCard);
        }

        $manager->flush();
    }
}