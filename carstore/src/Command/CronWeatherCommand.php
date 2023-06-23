<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Schedule\CronExpression;
use App\Service\MeteoService;

class CronWeatherCommand extends Command
{
    private MeteoService $meteoService;

    public function __construct(MeteoService $meteoService)
    {
        $this->meteoService = $meteoService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:update-weather')
            ->setDescription('Update weather service in the app');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {   
        $this->meteoService->fetchMeteo();
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }
        

        $io->success('You updated successfully the weather service!');

        return Command::SUCCESS;
    }

    protected function getDefaultDefinition()
    {
        return parent::getDefaultDefinition()->setSchedule(
            CronExpression::factory('0 * * * *') // Cron expression for scheduling
        );
    }
}
