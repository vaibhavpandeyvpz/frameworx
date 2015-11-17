<?php

namespace App\Middleware;

use Slim\Middleware as BaseMiddleware;

/**
 * Class Middleware
 * @package App\Middleware
 *
 * @property-read \App\Slim $app
 */
abstract class Middleware extends BaseMiddleware
{
    /**
     * @inheritdoc
     */
    public function call()
    {
        $this->hook();
        $this->next->call();
    }

    abstract protected function hook();
}
