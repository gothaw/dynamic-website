<?php

class ValidationRules
{
    public static function getRegisterUserRules()
    {
        $rulesArray = array_merge(self::getUpdateUserRules(), self::getValidUsernameRules(), self::getValidEmailRules(), self::getValidPasswordRules());

        return $rulesArray;
    }

    public static function getUpdateUserRules()
    {
        $rulesArray = self::getUserDetailsRules();

        return $rulesArray;
    }

    public static function getChangePasswordRules()
    {
        $passwordRules = self::getValidPasswordRules();

        $passwordRules['password']['desc'] = 'new password';
        $passwordRules['password_again']['desc'] = 'repeating new password';

        $rulesArray = array_merge([
            'password_current' => [
                'desc' => 'Your current password',
                'required' => true
            ]
        ], $passwordRules);

        return $rulesArray;
    }

    public static function getValidLoginRules()
    {
        $rulesArray = [
            'username' => [
                'desc' => 'username',
                'required' => true
            ],
            'password' => [
                'desc' => 'password',
                'required' => true
            ]
        ];

        return $rulesArray;
    }

    public static function getValidMessageRules()
    {
        $rulesArray = array_merge([
            'name' => [
                'desc' => 'your name',
                'required' => true,
                'min' => 2
            ],
            'subject' => [
                'desc' => 'email subject',
                'required' => true,
                'min' => 5,
                'max' => 20
            ]
        ],
            self::getValidEmailRules(),
            [
                'message' => [
                    'desc' => 'email message',
                    'required' => true,
                    'max' => 4000
                ]
            ]
        );

        return $rulesArray;
    }

    public static function getValidDateRules()
    {
        $rulesArray = [
            'date' => [
                'desc' => 'date',
                'date' => true,
            ]
        ];

        return $rulesArray;
    }

    private static function getUserDetailsRules()
    {
        $rulesArray = [
            'first_name' => [
                'desc' => 'your first name',
                'required' => true,
                'min' => 2,
                'max' => 20
            ],
            'last_name' => [
                'desc' => 'your last name',
                'required' => true,
                'min' => 2,
                'max' => 20
            ],
            'address_first_line' => [
                'desc' => 'your address',
                'required' => true
            ],
            'postcode' => [
                'desc' => 'your postcode',
                'required' => true
            ],
            'city' => [
                'desc' => 'city',
                'required' => true
            ]
        ];

        return $rulesArray;
    }

    private static function getValidUsernameRules()
    {
        $rulesArray = [
            'username' => [
                'desc' => 'your username',
                'required' => true,
                'min' => 6,
                'max' => 20,
                'unique' => 'user/u_username',
                'forbidden_characters' => true
            ]
        ];

        return $rulesArray;
    }

    private static function getValidEmailRules()
    {
        $rulesArray = [
            'email' => [
                'desc' => 'your email address',
                'required' => true,
                'email' => true,
                'unique' => 'user/u_email'
            ]
        ];

        return $rulesArray;
    }

    private static function getValidPasswordRules()
    {
        $rulesArray = [
            'password' => [
                'desc' => 'password',
                'required' => true,
                'contains_numerical' => true,
                'contains_uppercase' => true,
                'contains_lowercase' => true,
                'forbidden_characters' => true,
                'min' => 8
            ],
            'password_again' => [
                'desc' => 'repeating password',
                'required' => true,
                'matches' => 'password'
            ]
        ];

        return $rulesArray;
    }
}