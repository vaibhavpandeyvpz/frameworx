<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Serve extends Command
{
    protected function configure()
    {
        $this->addOption('host', 'H', InputOption::VALUE_OPTIONAL, 'The host address to listen for.', 'localhost')
            ->addOption('port', 'P', InputOption::VALUE_OPTIONAL, 'The port to bind upon.', 8080)
            ->setDescription('Serve the application using PHP development server.')
            ->setName('serve');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = $input->getOption('host');
        $port = (int) $input->getOption('port');
        chdir($this->getPath('www'));
        $output->writeln("Development server started on http://{$host}:{$port}/");
        passthru(PHP_BINARY . " -S {$host}:{$port} 2>&1");
    }
}
