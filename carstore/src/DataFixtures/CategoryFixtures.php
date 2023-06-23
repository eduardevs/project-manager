<?php

namespace App\DataFixtures;

use App\Entity\CarCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1; // Set the desired order number here
    }
    
    public function load(ObjectManager $manager): void
    {
        $categories = ['Executive', 'Luxury', 'Hybride', 'Electric', 'Pickup', 'Sportive'];
        
        forEach($categories as $category) {
            $carCategory = new CarCategory();
            $carCategory->setName($category);
            $manager->persist($carCategory);
        }

        $manager->flush();
    }
}
