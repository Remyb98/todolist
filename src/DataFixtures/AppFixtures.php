<?php

namespace App\DataFixtures;

use App\Data\TaskState;
use App\Entity\Task;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    const int TASK_COUNT = 500;
    const int USER_COUNT = 3;

    private Generator $faker;

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->createUsers($manager);
        $this->createTasks($manager, $users);
    }

    private function createUsers(ObjectManager $manager): array
    {
        $users = [];
        for ($i = 0; $i < self::USER_COUNT; $i++) {
            $user = new User();
            $user
                ->setUsername($this->faker->userName())
                ->setPassword(
                    $this->userPasswordHasher->hashPassword($user, '0000')
                )
                ->setEmail($this->faker->email());
            $manager->persist($user);
            $users[] = $user;
        }
        $manager->flush();
        return $users;
    }

    private function createTasks(ObjectManager $manager, array $users): void
    {
        $states = TaskState::cases();
        for ($i = 0; $i < self::TASK_COUNT; $i++) {
            $task = (new Task())
                ->setTitle($this->faker->text(25))
                ->setDescription($this->faker->text())
                ->setState($this->faker->randomElement($states))
                ->setDueDate(new DateTime($this->faker->date()))
                ->setCreatedBy($this->faker->randomElement($users))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($this->faker->dateTime()))
                ->setAssignee($this->faker->randomElement($users));
            $manager->persist($task);
        }
        $manager->flush();
    }
}
