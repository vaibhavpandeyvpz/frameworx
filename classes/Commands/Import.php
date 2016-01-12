<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    protected function configure()
    {
        $this->addOption('file', 'F', InputOption::VALUE_REQUIRED, 'File path to read SQL from')
            ->setDescription('Reads and imports SQL commands from a file.')
            ->setName('import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getOption('file');
        if (empty($file))  {
            throw new \InvalidArgumentException('Please specify a file path using -F or --file to import.');
        }
        $file = realpath($file);
        $sql = @file_get_contents($file);
        if (($sql !== false) && !empty($sql)) {
            $output->write(sprintf('Importing file <comment>%s</comment>...', $file));
            try {
                $this->getDb()->exec($sql);
                $output->writeln('<info>Done</info>');
            } catch (\Exception $e) {
                $output->writeln('<error>Failed</error>');
                throw new \RuntimeException($e);
            }
        }
    }
}
