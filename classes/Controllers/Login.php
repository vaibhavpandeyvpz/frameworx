<?php

namespace App\Controllers;

use Symfony\Component\Validator\Constraints as Assert;

class Login extends Controller
{
    public function check()
    {
        $constraints = new Assert\Collection(array(
            'email' => array(
                new Assert\Required(),
                new Assert\Email(),
            ),
            'password' => array(
                new Assert\Required(),
                new Assert\NotBlank(),
                new Assert\Length(array(
                    'min' => 8,
                    'max' => 32,
                )),
            )
        ));
        $errors = $this->app->validator->validate($data = array(
            'email' => $this->app->request->post('email'),
            'password' => $this->app->request->post('password'),
        ), $constraints);
        if (count($errors) <= 0) {
            if ($this->app->security->login($data['email'], $data['password'])) {
                $this->app->flashNow('flash.login.success', 'danger');
                $this->app->redirectTo('home');
            } else {
                $this->app->flashNow('flash.login.mismatch', 'danger');
            }
        } else {
            $this->app->flashNow('flash.login.invalid', 'danger');
        }
        $this->index();
    }

    public function index()
    {
        $this->app->render('login.twig', [
            'title' => 'titles.login'
        ]);
    }
}
