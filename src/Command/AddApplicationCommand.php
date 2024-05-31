<?php

namespace App\Command;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add:application',
)]
class AddApplicationCommand extends Command
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Ask for application name
        $applicationName = $io->ask('Enter application name');

        // Ask for application password
        $applicationPassword = $io->ask('Enter application password');

        // repeat password
        $applicationPasswordRepeat = $io->ask('Repeat application password');

        // Check if passwords are the same
        if ($applicationPassword !== $applicationPasswordRepeat) {
            $io->error('Passwords do not match');

            return Command::FAILURE;
        }

        $app = (new Application())
            ->setName($applicationName)
            ->setPassword($applicationPassword);

        $this->entityManager->persist($app);
        $this->entityManager->flush();

        $io->success('Application added successfully');

        return Command::SUCCESS;
    }

}
