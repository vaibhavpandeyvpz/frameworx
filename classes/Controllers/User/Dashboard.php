<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $this->app->render('user/dashboard.twig', [
            'title' => 'titles.user.dashboard'
        ]);
    }
}
