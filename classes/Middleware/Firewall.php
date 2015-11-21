<?php

namespace App\Middleware;

class Firewall extends Middleware
{
    /**
     * @var \Closure
     */
    protected $callback;

    /**
     * @var string
     */
    protected $pattern;

    function __construct($pattern, \Closure $callback)
    {
        $this->callback = $callback;
        $this->pattern = $pattern;
    }

    protected function hook()
    {
        $this->app->hook('slim.before.router', array($this, 'match'));
    }

    public function match()
    {
        if (preg_match("@{$this->pattern}?.+$@", $this->app->request->getPathInfo())) {
            call_user_func($this->callback->bindTo($this->app));
        }
    }
}
