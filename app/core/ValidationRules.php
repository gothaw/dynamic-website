<?php

class ValidationRules
{
    /**
     * @method                      getRegisterUserRules
     * @desc                        Validation rules for registering new user.
     * @return                      array
     */
    public static function getRegisterUserRules()
    {
        $rulesArray = array_merge(self::getUpdateUserRules(), self::getValidUsernameRules(), self::getValidEmailRules(), self::getValidPasswordRules());

        return $rulesArray;
    }

    /**
     * @method                      getRegisterUserRulesAdminPanel
     * @desc                        Validation rules for registering new user in admin panel.
     * @return                      array
     */
    public static function getRegisterUserRulesAdminPanel()
    {
        $rulesArray = array_merge(self::getUpdateUserRules(), self::getValidUsernameRules(), self::getValidEmailRules(), self::getValidPasswordRules(), [
            'permission' => [
                'desc' => 'User permission group',
                'required' => true
            ]
        ]);

        return $rulesArray;
    }

    /**
     * @method                      getUpdateUserRules
     * @desc                        Validation rules when user wants to update personal details.
     * @return                      array
     */
    public static function getUpdateUserRules()
    {
        $rulesArray = self::getUserDetailsRules();

        return $rulesArray;
    }

    /**
     * @method                      getUpdateUserRulesAdminPanel
     * @desc                        Validation rules to update user personal details from admin panel.
     * @return                      array
     */
    public static function getUpdateUserRulesAdminPanel()
    {
        $rulesArray = array_merge(self::getUserDetailsRules(), [
            'permission' => [
                'desc' => 'User permission group',
                'required' => true
            ]
        ]);

        return $rulesArray;
    }

    /**
     * @method                      getChangePasswordRules
     * @desc                        Validation rules when user wants to change password in dashboard panel.
     * @return                      array
     */
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

    /**
     * @method                      getValidLoginRules
     * @desc                        Rules for valid login attempt.
     * @return                      array
     */
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

    /**
     * @method                      getValidMessageRules
     * @desc                        Rules for valid message sent using contact form.
     * @return                      array
     */
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
                'min' => 2,
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

    /**
     * @method                      getValidDateRules
     * @desc                        Rules for valid date.
     * @return                      array
     */
    public static function getValidDateRules()
    {
        $rulesArray = [
            'date' => [
                'desc' => 'date',
                'date' => true,
                'required' => true
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getValidClassRules
     * @desc                        Rules for valid class details.
     * @return                      array
     */
    public static function getValidClassRules()
    {
        $rulesArray = [
            'class_name' => [
                'desc' => 'class name',
                'required' => true,
                'min' => 2,
                'max' => 25
            ],
            'duration' => [
                'desc' => 'class duration in minutes',
                'required' => true,
                'numeric' => true,
                'max_value' => 120,
                'min_value' => 15
            ],
            'max_no_people' => [
                'desc' => 'max number of people',
                'required' => true,
                'numeric' => true,
                'max_value' => 30,
                'min_value' => 5
            ],
            'class_image_text' => [
                'desc' => 'alternative image text',
                'required' => true,
                'min' => 2,
                'max' => 50
            ],
            'description' => [
                'desc' => 'class description',
                'required' => true,
                'min' => 5,
                'max' => 250
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getUserDetailsRules
     * @desc                        Rules for valid user details such as first name, last name and address.
     * @return                      array
     */
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

    /**
     * @method                      getValidUsernameRules
     * @desc                        Rules for valid username
     * @return                      array
     */
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

    /**
     * @method                      getValidEmailRules
     * @desc                        Rules for valid email address.
     * @return                      array
     */
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

    /**
     * @method                      getValidPasswordRules
     * @desc                        Rules for valid password.
     * @return                      array
     */
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