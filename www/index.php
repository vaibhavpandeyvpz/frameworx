<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager as DBAL;
use App\Middleware\Bootstrap;
use App\Middleware\Firewall;
use App\Slim;
use App\Services\Password;
use App\Services\Security;
use Mailgun\Mailgun;
use Slim\Middleware\SessionCookie;

$app = new Slim(require(__DIR__ . '/../config.php'));

$app->container->singleton('db', function () use ($app)
{
    return DBAL::getConnection(array(
        'charset' => $app->config('db.charset'),
        'dbname' => $app->config('db.name'),
        'driver' => $app->config('db.driver'),
        'host' => $app->config('db.host'),
        'password' => $app->config('db.password'),
        'port' => $app->config('db.port'),
        'user' => $app->config('db.user'),
    ));
});

$app->container->singleton('mailgun', function () use ($app)
{
    return new Mailgun($app->config('mailgun.key'));
});

$app->container->singleton('password', function () use ($app)
{
    return new Password();
});

$app->container->set('qb', function () use ($app)
{
    return $app->db->createQueryBuilder();
});

$app->container->singleton('security', function () use ($app)
{
    return new Security($app);
});

$app->add(new Bootstrap());

$app->add(new Firewall('^/user', function () use ($app)
{
    if ($app->security->check()) {
        $app->view()->set('user', $app->security->user());
    } else {
        $app->flash('You need to be logged in first', 'warning');
        $app->redirectTo('login');
    }
}));

$app->add(new Firewall('^/login', function () use ($app)
{
    if ($app->security->check()) {
        $app->flash('You are already logged in', 'info');
        $app->redirectTo('user_home');
    }
}));

$app->add(new SessionCookie(array(
    'expires' => $app->config('cookies.lifetime'),
    'name' => $app->config('session.cookie')
)));

$app->any('/', 'Home@index')
    ->setName('home');

$app->post('/login', 'Login@check')
    ->setName('login_check');

$app->group('/user', function () use ($app)
{
    $app->get('/logout', 'User\\Home@index')
        ->setName('user_home');

    $app->get('/logout', 'User\\Logout@index')
        ->setName('user_logout');

    $app->get('/profile', 'User\\Profile@index')
        ->setName('user_profile');
});

$app->run();
