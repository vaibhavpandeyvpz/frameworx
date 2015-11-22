<?php

namespace App\Services;

use App\Slim;

class Security
{
    /**
     * @var Slim
     */
    private $app;

    /**
     * @var array
     */
    private $user;

    /**
     * Security constructor.
     * @param Slim $app
     */
    function __construct(Slim $app)
    {
        $this->app = $app;
        $id = isset($_SESSION[$app->config('security.session')]) ? (int) $_SESSION[$app->config('security.session')] : -1;
        if ($id >= 1) {
            $qb = $this->app->qb;
            $qb->select('*')
                ->from($app->config('security.table'))
                ->where($qb->expr()->eq($app->config('security.field.pk'), '?'))
                ->setParameter(0, $id);
            $result = $qb->execute();
            if ($result->rowCount() == 1) {
                $user = $result->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                    $this->user = $user;
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function check()
    {
        return ($this->user !== false) && ($this->user['id'] >= 1);
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password)
    {
        $qb = $this->app->qb;
        $qb->select('*')
            ->from($this->app->config('security.table'))
            ->where($qb->expr()->eq($this->app->config('security.field.username'), '?'))
            ->setParameter(0, $username);
        $result = $qb->execute();
        if ($result->rowCount() == 1) {
            $user = $result->fetch(\PDO::FETCH_ASSOC);
            if ($this->match($password, $user[$this->app->config('security.field.password')])) {
                $_SESSION[$this->app->config('security.session')] = $user[$this->app->config('security.field.pk')];
                $this->user = $user;
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        if (isset($_SESSION[$this->app->config('security.session')])) {
            unset($_SESSION[$this->app->config('security.session')]);
        }
        $this->user = false;
    }

    public function match($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * @param $password
     * @return bool
     */
    public function setPassword($password)
    {
        $qb = $this->app->qb;
        $qb->update($this->app->config('security.table'))
            ->set($this->app->config('security.field.password'), '?')
            ->where($qb->expr()->eq($this->app->config('security.field.pk'), '?'))
            ->setParameter(0, $this->hash($password))
            ->setParameter(1, $this->user[$this->app->config('security.field.pk')]);
        return $qb->execute() == 1;
    }

    /**
     * @return array|mixed
     */
    public function user()
    {
        return $this->user;
    }
}
