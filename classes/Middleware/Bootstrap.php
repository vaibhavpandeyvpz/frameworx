<?php

namespace App\Middleware;

class Bootstrap extends Middleware
{
    public function boot()
    {
        $this->app->config('locale.user', $this->app->config('locale.default'));
    }

    protected function hook()
    {
        $this->app->hook('slim.before.router', array($this, 'boot'));
    }
}
