<?php

namespace App;

use Slim\Slim as BaseSlim;

class Slim extends BaseSlim
{
    /**
     * @param $args
     * @return \Slim\Route
     */
    protected function mapRoute($args)
    {
        $callable = array_pop($args);
        if (is_string($callable) && (strpos($callable, '@') !== false)) {
            list($controller, $action) = explode('@', $callable);
            $app = $this;
            $callable = function () use ($app, $controller, $action)
            {
                if ($app->container->has($controller)) {
                    $controller = $app->container[$controller];
                } else {
                    $controller = "\\App\\Controllers\\" . $controller;
                    $controller = new $controller($app);
                }
                return call_user_func_array(array($controller, $action), func_get_args());
            };
        }
        $args[] = $callable;
        return parent::mapRoute($args);
    }
}
