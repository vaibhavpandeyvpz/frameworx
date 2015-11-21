<?php

namespace App\Controllers;

class Home extends Controller
{
    public function index()
    {
        $this->app->render('home.twig', [
            'title' => 'titles.home'
        ]);
    }
}
