<?php

namespace App\Services\Ext;

use Slim\Slim;

class Twig extends \Twig_Extension
{
    /**
     * @var \App\Slim
     */
    private $app;

    /**
     * Twig constructor.
     * @param Slim $app
     */
    function __construct(Slim $app)
    {
        $this->app = $app;
    }

    public function getFilterTrans()
    {
        return call_user_func_array(array($this->app->translator, 'trans'), func_get_args());
    }

    public function getFilterTransChoice()
    {
        return call_user_func_array(array($this->app->translator, 'transChoice'), func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans', array($this, 'getFilterTrans')),
            new \Twig_SimpleFilter('transChoice', array($this, 'getFilterTransChoice')),
        );
    }

    public function getFuncAsset($path)
    {
        $uri = $this->app->request->getUrl();
        return $uri . '/' . ltrim($path, '/');
    }

    public function getFuncIsLoggedIn()
    {
        return $this->app->security->check();
    }

    public function getFuncRoute($name, array $params = array())
    {
        return $this->app->request->getUrl() . $this->app->router->urlFor($name, $params);
    }

    public function getFuncUrl($query = true)
    {
        $request = $this->app->request;
        $url = $request->getUrl() . $request->getPath();
        if ($query) {
            $environment = $this->app->environment;
            if ($environment['QUERY_STRING']) {
                $url .= '?' . $environment['QUERY_STRING'];
            }
        }
        return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('asset', array($this, 'getFuncAsset')),
            new \Twig_SimpleFunction('is_logged_in', array($this, 'getFuncIsLoggedIn')),
            new \Twig_SimpleFunction('route', array($this, 'getFuncRoute')),
            new \Twig_SimpleFunction('url', array($this, 'getFuncUrl')),
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'frameworx';
    }
}
