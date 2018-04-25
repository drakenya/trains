<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixtures extends Fixture
{
    private $userManager;
    private $encoderFactory;

    public function __construct(UserManagerInterface $userManager, EncoderFactoryInterface $encoderFactory)
    {
        $this->userManager = $userManager;
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->userManager->createUser()
            ->setUsername('admin')
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setEnabled(true)
        ;
        $user->setPassword($this->encoderFactory->getEncoder($user)->encodePassword('admin', $user->getSalt()));

        $this->userManager->updateUser($user);

        $manager->flush();
    }
}
