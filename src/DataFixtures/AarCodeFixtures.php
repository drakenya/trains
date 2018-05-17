<?php

namespace App\DataFixtures;

use App\Entity\AarCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class AarCodeFixtures extends Fixture
{
    public const REFERENCE = 'aar-code';
    public const FIXTURES_TO_GENERATE = 5;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $class = $this->faker->regexify('[A-D]');
            $aarCode = (new AarCode())
                ->setClass($class)
                ->setCode($class . strtoupper($this->faker->randomLetter))
                ->setCommonName($this->faker->words(2, true))
                ->setDescription($this->faker->words(10, true))
            ;
            $manager->persist($aarCode);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $aarCode);
        }

        $manager->flush();
    }
}
