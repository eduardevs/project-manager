<?php

namespace App\DataFixtures;

use App\Entity\User;

use App\Entity\Project;
use Faker\Factory;

use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();

        // $user = $manager->getRepository(User::class)->findAll([ 'id' => 33]);
        $projects = range(0, 20);

        for ($i = 0; $i < count($projects); $i++) {
            $project = new Project();
            $project->setName($faker->word());
            $project->setDescription($faker->paragraph());
            $project->setOwner($users[array_rand($users)]);

            // to add many members
            for ($j = 0; $j < count($projects); $j++) {
                $project->addMember(
                    $users[mt_rand(0, count($users) - 1)]
                );
            }

            $manager->persist($project);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
