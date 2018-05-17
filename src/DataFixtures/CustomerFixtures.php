<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'customer';
    public const FIXTURES_TO_GENERATE = 20;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $customer = (new Customer())
                ->setName($this->faker->company)
                ->setLocation($this->getReference(sprintf('%s-%s', LocationFixtures::REFERENCE, rand(1, LocationFixtures::FIXTURES_TO_GENERATE))))
            ;
            $manager->persist($customer);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $customer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
        ];
    }
}