<?php

namespace Nat\DebtTracker\Users\Validators;

use Respect\Validation\Validator as Validator;

class Register
{
    private $name;
    private $email;
    private $password;
    private $errors = [];

    public function __construct($args)
    {
        $this->name = $args['name'];
        $this->email = [$args['email'], $args['email-confirmed']];
        $this->password = [$args['password'], $args['password-confirmed']];
    }

    public function validate()
    {
        if ($this->validateName() & $this->validateEmail() & $this->validatePassword()) {
            return true;
        } else {
            return $this->errors;
        }
    }

    public function validateName()
    {
        $nameValidator = Validator::stringType()->length(4, 15);

         if ($nameValidator->validate($this->name)) {
             return true;
         } else {
             array_push($this->errors, "Name");
             return false;
         }
    }

    public function validateEmail()
    {
        if ($this->email[0] !== $this->email[1]) {
            array_push($this->errors, "email not matching");
            return false;
        }

        if(Validator::email()->validate($this->email[0])) {
            return true;
        } else {
            array_push($this->errors, "email");
            return false;
        }
    }

    public function validatePassword()
    {
        if ($this->password[0] !== $this->password[1]) {
            array_push($this->errors, "passwords not matching");
            return false;
        }

        $passwordValidator = Validator::alnum()
            ->noWhitespace()
            ->length(6, 20)
            ->regex('/[0-9]/')
            ->regex('/[A-Z]/')
            ->regex('/[a-z]/');

        if ($passwordValidator->validate($this->password[0])) {
            return true;
        } else {
            array_push($this->errors, "password");
            return false;
        }
    }
}