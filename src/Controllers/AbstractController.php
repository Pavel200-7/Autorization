<?php

namespace App\Controllers;

use App\DataBase\UserDB;
use App\Services\SuccessMessage;

abstract class AbstractController
{
    protected UserDB $userDB;
    protected SuccessMessage $successMessage;

    public function __construct()
    {
        $this->userDB = new UserDB();
        $this->successMessage = new SuccessMessage();
    }

}