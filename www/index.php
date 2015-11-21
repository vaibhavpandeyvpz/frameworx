<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager as DBAL;
use App\Middleware\Bootstrap;
use App\Middleware\Firewall;
use App\Slim;
use App\Services\Security;
use Mailgun\Mailgun;
use Slim\Middleware\SessionCookie;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;

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

$app->container->set('qb', function () use ($app)
{
    return $app->db->createQueryBuilder();
});

$app->container->singleton('security', function () use ($app)
{
    return new Security($app);
});

$app->container->singleton('translator', function () use ($app)
{
    $translator = new Translator($app->config('locale.user'));
    $translator->addLoader('php', new PhpFileLoader());
    $translator->setFallbackLocales(array($app->config('locale.default')));
    foreach ($app->config('locale.all') as $locale) {
        $translator->addResource('php', sprintf($app->config('locale.path'), $locale), $locale);
    }
    return $translator;
});

$app->add(new Bootstrap());

$app->add(new Firewall('^/user', function ()
{
    if (!$this->security->check()) {
        $this->flash('flash.login.required', 'warning');
        $this->redirectTo('login');
    }
}));

$app->add(new Firewall('^/login', function ()
{
    if ($this->security->check()) {
        $this->flash('flash.login.already', 'info');
        $this->redirectTo('home');
    }
}));

$app->add(new SessionCookie(array(
    'expires' => $app->config('cookies.lifetime'),
    'name' => $app->config('session.cookie')
)));

$app->any('/', 'Home@index')
    ->setName('home');

$app->get('/login', 'Login@index')
    ->setName('login');

$app->post('/login', 'Login@check')
    ->setName('login_check');

$app->group('/user', function () use ($app)
{
    $app->get('/', 'User\\Dashboard@index')
        ->setName('user_dashboard');

    $app->get('/logout', 'User\\Logout@index')
        ->setName('user_logout');

    $app->get('/profile', 'User\\Profile@index')
        ->setName('user_profile');
});

$app->container->set('validator', function ()
{
    return Validation::createValidatorBuilder()
        ->getValidator();
});

$app->run();
