<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Project;
use App\DataFixtures\ProjectFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $projects = $manager->getRepository(Project::class)->findAll();

        for($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle($faker->sentence());
            $task->setDescription($faker->paragraph());
            $task->setStatus(['NOT_STARTED']);
            // $task->setPriority([])
            $task->setDueDate(new \DateTime('now'));
            $task->addAssignedTo($users[array_rand($users)]);
            $task->setProject($projects[array_rand($projects)]);
            $task->setCreatedBy($users[array_rand($users)]);
    
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProjectFixtures::class,
        ];
    }
}
