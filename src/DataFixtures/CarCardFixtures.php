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
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class WaybillFixtures extends Fixture
{
    private const FIXTURES_TO_GENERATE = 13;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < static::FIXTURES_TO_GENERATE; $i++) {
            $waybill = (new Waybill())
                ->setFromAddress(sprintf('%s, %s', $faker->city, $faker->stateAbbr))
                ->setToAddress(sprintf('%s, %s', $faker->city, $faker->stateAbbr))
                ->setShipper($faker->company)
                ->setConsignee($faker->company)
                ->setAarClass($faker->randomElement(['XM', 'XA', 'HT']))
                ->setLengthCapacity($faker->randomElement(["40'", "50'", "70t", "100t"]))
                ->setRouteVia($faker->regexify('([A-Z]{2,3}-){0,2}[A-Z]{2,3}'))
                ->setSpotLocation(sprintf('%s.%s', $faker->randomNumber(3), $faker->randomNumber(3)))
                ->setLadingQuantity($faker->randomElement(['C/L']))
                ->setLadingDescription($faker->words(2, true))
            ;
            $manager->persist($waybill);
        }

        $manager->flush();
    }
}