<?php

namespace App\Commands;

use Consoler\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDb()
    {
        return $this->getContainer()->get('db');
    }

    /**
     * @param string $suffix
     * @return string
     */
    protected function getPath($suffix)
    {
        $path = $this->getContainer()->get('root');
        return $path . '/' . ltrim($suffix, '/');
    }
}
