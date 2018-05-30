<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 10:45 AM
 */

namespace App\DataFixtures;

use App\Entity\Waybill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class WaybillFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE = 'waybill';
    public const FIXTURES_TO_GENERATE = 13;

    private $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $shipperIndex = rand(1, CustomerFixtures::FIXTURES_TO_GENERATE);
            $consigneeIndex = ($shipperIndex % CustomerFixtures::FIXTURES_TO_GENERATE) + 1;

            $waybill = (new Waybill())
                ->setAarCode($this->getReference(sprintf('%s-%s', AarCodeFixtures::REFERENCE, rand(1, AarCodeFixtures::FIXTURES_TO_GENERATE))))
                ->setRouteVia($this->faker->regexify('([A-Z]{2,3}-){5,8}[A-Z]{2,3}'))
                ->setStopAt(sprintf('%s.%s', $this->faker->randomNumber(1), $this->faker->randomNumber(3)))
                ->setLadingQuantity($this->faker->randomElement(['C/L']))
                ->setLadingDescription($this->faker->words(2, true))
                ->setInstructionsExceptions($this->faker->optional(0.25)->words(3, true))
            ;
            if (rand(1, 100) > 25) {
                $waybill->setShipper($this->getReference(sprintf('%s-%s', CustomerFixtures::REFERENCE, $shipperIndex)));
            }
            if (rand(1, 100) > 25) {

                $waybill->setConsignee($this->getReference(sprintf('%s-%s', CustomerFixtures::REFERENCE, $consigneeIndex)));
            }

            $manager->persist($waybill);

            $this->addReference(sprintf('%s-%s', static::REFERENCE, ($i + 1)), $waybill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
        ];
    }
}