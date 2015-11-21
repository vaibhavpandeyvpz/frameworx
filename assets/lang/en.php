<?php

return array(
    'app' => 'Frameworx',
    'buttons' => array(
        'login' => 'Login'
    ),
    'fields' => array(
        'email' => array(
            'label' => 'Email',
            'placeholder' => 'address@domain.tld'
        ),
        'password' => array(
            'label' => 'Password',
            'placeholder' => 'secret'
        ),
    ),
    'flash' => array(
        'login' => array(
            'already' => 'You are already logged in',
            'invalid' => 'Please enter valid email & password',
            'mismatch' => 'Email & password you entered do not match',
            'required' => 'You need to be logged in first',
            'success' => 'You are now logged in',
        ),
        'logout' => array(
            'done' => 'You have been logged out',
        ),
    ),
    'img' => array(
        'logo' => 'Logo'
    ),
    'titles' => array(
        'home' => 'Home',
        'login' => 'Login Required',
        'user' => array(
            'home' => 'User -> Home',
            'profile' => 'User -> Profile',
        ),
    ),
);
