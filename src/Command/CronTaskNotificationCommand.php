<?php

namespace App\Command;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

#[AsCommand(
    name: 'app:cron:task:notification',
    description: 'Send an email listing incoming tasks and late ones',
)]
class CronTaskNotificationCommand extends Command
{
    public function __construct(
        private readonly UserRepository  $userRepository,
        private readonly TaskRepository  $taskRepository,
        private readonly MailerInterface $mailer
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $comingTasks = $this->taskRepository->findComingTasksByUser($user);
            $lateTasks = $this->taskRepository->findLateTasksByUser($user);

            $email = (new TemplatedEmail())
                ->from('my-todo@training.com')
                ->to($user->getEmail())
                ->subject('[My-Todo] Daily recap')
                ->htmlTemplate('task/email.html.twig')
                ->context([
                    'user' => $user,
                    'comingTasks' => $comingTasks,
                    'lateTasks' => $lateTasks
                ]);

            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
            }
        }

        return Command::SUCCESS;
    }
}
