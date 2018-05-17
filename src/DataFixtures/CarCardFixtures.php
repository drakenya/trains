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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class CarCardFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'car-card';
    public const FIXTURES_TO_GENERATE = 43;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $carCard = (new CarCard())
                ->setRailroad($this->getReference(sprintf('%s-%s', RailroadFixtures::REFERENCE, rand(1, RailroadFixtures::FIXTURES_TO_GENERATE))))
                ->setCarNumber($this->faker->numberBetween(1000, 999999))
                ->setAarCode($this->getReference(sprintf('%s-%s', AarCodeFixtures::REFERENCE, rand(1, AarCodeFixtures::FIXTURES_TO_GENERATE))))
                ->setLengthCapacity($this->faker->optional(0.80)->randomElement(["40'", "50'", "70t", "100t"]))
                ->setDescription($this->faker->optional(0.25)->words(2, true))
            ;
            $manager->persist($carCard);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $carCard);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AarCodeFixtures::class,
            RailroadFixtures::class,
        ];
    }
}