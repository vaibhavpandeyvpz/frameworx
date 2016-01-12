<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class Configure extends Command
{
    private function cloneSample($path, array $search, array $replace)
    {
        $contents = file_get_contents($path);
        $path = substr($path, 0, -7);
        $contents = str_replace($search, $replace, $contents);
        if (file_exists($path)) {
            unlink($path);
        }
        file_put_contents($path, $contents);
    }

    protected function configure()
    {
        $this->setDescription('Configures the application for use (Removes previous configuration).')
            ->setName('configure');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $helper \Symfony\Component\Console\Helper\QuestionHelper */
        $helper = $this->getHelper('question');
        if ($helper->ask($input, $output, new ConfirmationQuestion('Recreate configuration file? '))) {
            $database = $helper->ask($input, $output, new Question('Enter database name (frameworx): ', 'frameworx'));
            $user = $helper->ask($input, $output, new Question('Enter database user (root): ', 'root'));
            $password = $helper->ask($input, $output, new Question("Enter password for user '{$user}': ", null));
            if ($helper->ask($input, $output, new ConfirmationQuestion('Save? '))) {
                $search = ['#DB_NAME', '#DB_USER', '#DB_PASSWORD', '#COOKIES_SECRET_KEY', '#SESSION_COOKIE_NAME', '#SECURITY_SESSION_NAME'];
                $replace = [$database, $user, $password, $this->getRandomString(), $this->getRandomString(8, false), $this->getRandomString(8, false)];
                $this->cloneSample($this->getPath('config.php.sample'), $search, $replace);
            }
        }
        if ($helper->ask($input, $output, new ConfirmationQuestion('Recreate vhost file? '))) {
            $host = $helper->ask($input, $output, new Question('Enter host name (framework.dev): ', 'frameworx.dev'));
            $port = (int) $helper->ask($input, $output, new Question('Enter port (8080): ', '8080'));
            $search = ['#APP_HOST', '#APP_PORT', '#APP_DOCUMENT_ROOT'];
            $replace = [$host, $port, $this->getPath('www')];
            $this->cloneSample($this->getPath('vhost.conf.sample'), $search, $replace);
        }
    }

    private function getRandomString($length = 16, $special = true)
    {
        $chars = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVWwxXyYzZ0123456789';
        if ($special) {
            $chars .= '+-_()*^%#@!';
        }
        $string = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, $max)];
        }
        return $string;
    }
}
