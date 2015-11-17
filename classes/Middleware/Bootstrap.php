<?php

namespace App\Middleware;

class Bootstrap extends Middleware
{
    public function boot()
    {
    }

    protected function hook()
    {
        $this->app->hook('slim.before.router', array($this, 'boot'));
    }
}
