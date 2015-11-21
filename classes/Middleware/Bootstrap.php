<?php

namespace App\Middleware;

class Bootstrap extends Middleware
{
    public function boot()
    {
        $this->app->config('locale.user', $this->app->config('locale.default'));
        $this->app->view()->set('user', $this->app->security->user());
    }

    protected function hook()
    {
        $this->app->hook('slim.before.router', array($this, 'boot'));
    }
}
