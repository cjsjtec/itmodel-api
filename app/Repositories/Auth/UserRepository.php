<?php
namespace App\Repositories\Auth;

use App\Entities\Auth\User;
use App\Repositories\Repository;

class UserRepository extends Repository
{
    /**
     *
     * @var User
     */
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

}