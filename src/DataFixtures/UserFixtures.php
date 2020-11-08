<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $userRole = new Role();
        $userRole->setName('ROLE_USER');
        $manager->persist($userRole);

        $adminRole = new Role();
        $adminRole->setName('ROLE_ADMIN');
        $manager->persist($adminRole);

        $manager->flush();
        
        $user = new User();
        $user->setEmail($faker->safeEmail)
            ->setPassword($this->encoder->encodePassword($user, 'user'))
            ->addUserRole($userRole)
        ;

        $manager->persist($user);
        $manager->flush();
        
        $user = new User();
        $user->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'user'))
            ->addUserRole($userRole)
        ;

        $manager->persist($user);
        $manager->flush();
        
        $user = new User();
        $user->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->addUserRole($userRole)
            ->addUserRole($adminRole)
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
