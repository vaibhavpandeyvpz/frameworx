<?php

namespace App\Controllers;

use App\Slim;

abstract class Controller
{
    /**
     * @var Slim
     */
    protected $app;

    /**
     * Controller constructor.
     * @param Slim $app
     */
    function __construct(Slim $app)
    {
        $this->app = $app;
    }

    abstract public function index();
}
