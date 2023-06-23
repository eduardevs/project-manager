<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(CarCategory::class)->findAll();
        $faker = Factory::create();


    
        for($i = 0; $i < 60; $i++) {
            $car= new Car();
            // $category->setName(array_rand($categories));

            $car->setName($faker->firstName());
            // $car->setBrand($brands[$i]);
            $car->setNbSeats(rand(1, 5));
            $car->setNbDoors(rand(1, 4));
            $car->setCost(rand(1000, 100000));
            $car->setCategory($categories[array_rand($categories)]);

            $manager->persist($car);

        }
        $manager->flush();
    }
}
