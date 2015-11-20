<?php

namespace App\Services;

class Password
{
    public function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
