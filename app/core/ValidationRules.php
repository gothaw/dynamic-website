<?php

class ValidationRules
{
    public static function getValidUserRules()
    {
        $rulesArray = [
            'first_name' => [
                'name' => 'your first name',
                'required' => true,
                'min' => 2,
                'max' => 20
            ],
            'last_name' => [
                'name' => 'your last name',
                'required' => true,
                'min' => 2,
                'max' => 20
            ],
            'address_first_line' => [
                'name' => 'your address',
                'required' => true
            ],
            'postcode' => [
                'name' => 'your postcode',
                'required' => true
            ],
            'city' => [
                'name' => 'city',
                'required' => true
            ],
            'username' => [
                'name' => 'your username',
                'required' => true,
                'min' => 6,
                'max' => 20,
                'unique' => 'user/u_username'
            ],
            'email' => [
                'name' => 'your email address',
                'required' => true,
                'email' => true
            ],
            'password' => [
                'name' => 'password',
                'required' => true,
                'contains_numerical' => true,
                'contains_uppercase' => true,
                'contains_lowercase' => true,
                'min' => 8
            ],
            'password_again' => [
                'name' => 'repeating password',
                'required' => true,
                'matches' => 'password'
            ]
        ];
        return $rulesArray;
    }

    public static function getValidLoginRules()
    {
        $rulesArray = [
            'username' => [
                'name' => 'username',
                'required' => true
            ],
            'password' => [
                'name' => 'password',
                'required' => true
            ]
        ];
        return $rulesArray;
    }
}