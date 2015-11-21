<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->app->render('user/home.twig', [
            'title' => 'titles.user.home'
        ]);
    }
}
