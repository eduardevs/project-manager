<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $brands= ['toyota', 'jeep', 'mercedes benz', 'tesla', 'peugeot', 'citroen', 'fiat', 'lambo', 'toto', 'test'];
        
    
        for($i = 0; $i< 10; $i++) {
            $car= new Car();
            // $category->setName(array_rand($categories));

            $car->setName($faker->firstName());
            // $car->setBrand($brands[$i]);
            $car->setNbSeats(rand(1, 5));
            $car->setNbDoors(rand(1, 4));
            $car->setCost(rand(1000, 100000));
            // $car->setCategory($category->setName('Executive'));

            $manager->persist($car);

        }
        $manager->flush();
    }
}
