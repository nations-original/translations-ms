<?php

namespace App\Command;

use App\Entity\Application;
use App\Entity\Locale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add:locale',
)]
class AddLocaleCommand extends Command
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // ask for the locale key
        $locale = $io->ask('Please enter the locale key (e.g. en, de, fr, etc.)');

        // ask for the application name
        $name = $io->ask('Please enter the application name');

        // Check if the application exists
        $application = $this->entityManager
            ->getRepository(Application::class)
            ->findOneBy(['name' => $name]);

        if (!$application) {
            $io->error('Application not found');

            return Command::FAILURE;
        }

        // Create the locale
        $locale = (new Locale())
            ->setName($locale)
            ->setApplication($application);

        $this->entityManager->persist($locale);
        $this->entityManager->flush();

        $io->success('Locale added successfully');

        return Command::SUCCESS;
    }

}
