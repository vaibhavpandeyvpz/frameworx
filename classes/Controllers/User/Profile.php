<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

class Profile extends Controller
{
    public function index()
    {
        $this->app->render('user/profile.twig', [
            'title' => 'titles.user.profile'
        ]);
    }
}
