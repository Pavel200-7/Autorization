<?php

namespace App\Services;

class SuccessMessage
{
    public function getSeccessMessagePage(string $message)
    {
        $successMessage = array();
        $successMessage['page'] = $message;
        return $successMessage;
    }

    public function getSeccessMessageName(string $message)
    {
        $successMessage = array();
        $successMessage['name'] = $message;
        return $successMessage;
    }

    public function getSeccessMessagePhone(string $message)
    {
        $successMessage = array();
        $successMessage['phone'] = $message;
        return $successMessage;
    }

    public function getSeccessMessageEmail(string $message)
    {
        $successMessage = array();
        $successMessage['email'] = $message;
        return $successMessage;
    }

    public function getSeccessMessagePassword(string $message)
    {
        $successMessage = array();
        $successMessage['password'] = $message;
        return $successMessage;
    }
}