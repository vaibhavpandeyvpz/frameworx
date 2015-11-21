<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class Logout extends Controller
{
    public function index()
    {
        $this->app->security->logout();
        $this->app->flash('flash.logout.done', 'info');
        $this->app->redirectTo('login');
    }
}
