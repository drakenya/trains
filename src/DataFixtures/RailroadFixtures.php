<?php

namespace App\DataFixtures;

use App\Entity\Railroad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class RailroadFixtures extends Fixture
{
    public const REFERENCE = 'railroad';
    public const FIXTURES_TO_GENERATE = 10;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $railroad = (new Railroad())
                ->setReportingMark($this->faker->regexify('[A-Z]{1,2}&?[A-Z]'))
                ->setName($this->faker->words(2, true))
            ;
            $manager->persist($railroad);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $railroad);
        }

        $manager->flush();
    }
}
