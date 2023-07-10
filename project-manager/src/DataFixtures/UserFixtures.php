<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('eduadevs@gmail.com')
            ->setFirstName('Eduardo')
            ->setPlainPassword('87654321');

            $manager->persist($user);

        for ($i = 0; $i < 9; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setPlainPassword('password');

            $manager->persist($user);
        }


        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // Set the desired order number here
    }
    
}
