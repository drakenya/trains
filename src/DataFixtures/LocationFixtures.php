<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class LocationFixtures extends Fixture
{
    public const REFERENCE = 'location';
    public const FIXTURES_TO_GENERATE = 5;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $location = (new Location())
                ->setStationName($this->faker->city)
                ->setState($this->faker->stateAbbr)
                ->setOnLayout($this->faker->boolean(50))
            ;
            $manager->persist($location);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $location);
        }

        $manager->flush();
    }
}
