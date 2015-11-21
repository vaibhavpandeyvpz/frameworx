<?php

namespace App;

use Slim\Slim as BaseSlim;

/**
 * Class Slim
 * @package App
 *
 * @property-read \Doctrine\DBAL\Connection $db
 * @property-read \Mailgun\Mailgun $mailgun
 * @property-read \Doctrine\DBAL\Query\QueryBuilder $qb
 * @property-read \App\Services\Security $security
 * @property-read \Symfony\Component\Translation\Translator $translator
 * @property-read \Symfony\Component\Validator\Validator\ValidatorInterface $validator
 */
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
