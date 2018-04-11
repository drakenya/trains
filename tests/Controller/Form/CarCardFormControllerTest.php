<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/10/18
 * Time: 11:47 AM
 */

namespace App\Tests\Controller\Form;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarCardFormControllerTest extends WebTestCase
{
    public function testShowWaybills()
    {
        $client = static::createClient();

        $client->request('GET', '/form/car-card/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}