<?php

namespace App\Services;

use App\Slim;
use Slim\View;

class Twig extends View
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    function __construct()
    {
        parent::__construct();
        $app = Slim::getInstance();
        $loader = new \Twig_Loader_Filesystem($app->config('view.path'));
        $this->twig = new \Twig_Environment($loader, $app->config('view.options'));
        $this->twig->addExtension(new Ext\Twig($app));
        $this->set('app', $app);
    }

    /**
     * @{@inheritdoc}
     */
    public function render($template, $data = array())
    {
        $template = $this->twig->loadTemplate($template);
        $data = array_merge($this->all(), (array) $data);
        return $template->render($data);
    }
}
