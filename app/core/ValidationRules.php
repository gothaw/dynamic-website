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
        $rulesArray = array_merge(self::getUpdateUserRules(), self::getUsernameRules(), self::getUserEmailRules(), self::getPasswordRules());

        return $rulesArray;
    }

    /**
     * @method                      getRegisterUserRulesAdminPanel
     * @desc                        Validation rules for registering new user in admin panel.
     * @return                      array
     */
    public static function getRegisterUserRulesAdminPanel()
    {
        $rulesArray = array_merge(self::getUpdateUserRules(), self::getUsernameRules(), self::getUserEmailRules(), self::getPasswordRules(), [
            'permission' => [
                'desc' => 'User permission group',
                'required' => true
            ]
        ]);

        return $rulesArray;
    }

    /**
     * @method                      getScheduledClassRules
     * @desc                        Validation rules for adding and editing a scheduled class.
     * @return                      array
     */
    public static function getScheduledClassRules()
    {
        $rulesArray = array_merge([
            'class' => [
                'desc' => 'class',
                'required' => true,
                'exists' => 'class/cl_id'
            ],
            'coach' => [
                'desc' => 'coach',
                'required' => true,
                'exists' => 'coach/co_id'
            ]
        ], self::getFutureDateRules(), self::getTimeRules());

        return $rulesArray;
    }

    /**
     * @method                      getPostRules
     * @desc                        Validation rules for adding and deleting posts in admin panel.
     * @return                      array
     */
    public static function getPostRules()
    {
        $rulesArray = array_merge([
            'post_title' => [
                'desc' => 'post title',
                'required' => true,
                'min' => 2,
                'max' => 150
            ],
            'post_category' => [
                'desc' => 'post category',
                'required' => true,
                'min' => 2,
            ],
            'post_author' => [
                'desc' => 'post author',
                'required' => true,
                'min' => 2,
            ],
            'post_tags' => [
                'desc' => 'post tags',
                'required' => true,
                'min' => 2
            ],
            'post_image' => [
                'desc' => 'post image',
                'required' => true,
                'exists' => 'post_img/p_img_id'
            ],
            'post_text' => [
                'desc' => 'post body',
                'required' => true,
                'min' => 50,
                'max' => 5000
            ]
        ], self::getDateRules(), self::getTimeRules());

        return $rulesArray;
    }

    /**
     * @method                      getEditPostCommentRules
     * @desc                        Valid rules for post comment. Used when editing post comment in admin panel.
     * @return                      array
     */
    public static function getEditPostCommentRules()
    {
        $rulesArray = array_merge(self::getAddPostCommentRules(),
            [
                'comment_author' => [
                    'desc' => 'comment author',
                    'required' => true,
                    'min' => 2,
                    'max' => 120
                ]
            ], self::getDateRules(), self::getTimeRules());

        return $rulesArray;
    }

    /**
     * @method                      getAddPostCommentRules
     * @desc                        Valid rules for comment text. Used when user adds comment under a post.
     * @return                      array
     */
    public static function getAddPostCommentRules()
    {
        $rulesArray = [
            'comment_text' => [
                'desc' => 'comment body',
                'required' => true,
                'min' => 2,
                'max' => 2000
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getUserIdRules
     * @desc                        Valid user id rules. Used for signing up user to a scheduled class in admin panel.
     * @return                      array
     */
    public static function getUserIdRules()
    {
        $rulesArray = [
            'user_id' => [
                'desc' => 'user',
                'required' => true,
                'exists' => 'user/u_id'
            ]
        ];

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
        $passwordRules = self::getPasswordRules();

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
     * @method                      getLoginRules
     * @desc                        Rules for valid login attempt.
     * @return                      array
     */
    public static function getLoginRules()
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
     * @method                      getContactFormMessageRules
     * @desc                        Rules for valid message sent using contact form.
     * @return                      array
     */
    public static function getContactFormMessageRules()
    {
        $rulesArray = [
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
            ],
            'email' => [
                'desc' => 'your email address',
                'required' => true,
                'email' => true
            ],
            'message' => [
                'desc' => 'email message',
                'required' => true,
                'max' => 4000
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getDateRules
     * @desc                        Rules for valid date.
     * @return                      array
     */
    public static function getDateRules()
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
     * @method                      getFutureDateRules
     * @desc                        Rules for valid future date.
     * @return                      array
     */
    public static function getFutureDateRules()
    {
        $rulesArray = [
            'date' => [
                'desc' => 'date',
                'future_date' => true,
                'required' => true
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getTimeRules
     * @desc                        Rules for valid time.
     * @return                      array
     */
    public static function getTimeRules()
    {
        $rulesArray = [
            'time' => [
                'desc' => 'time',
                'time' => true,
                'required' => true
            ]
        ];

        return $rulesArray;
    }

    /**
     * @method                      getCoachDetailsRules
     * @desc                        Rules for valid coach details.
     * @return                      array
     */
    public static function getCoachDetailsRules()
    {
        $rulesArray = [
            'first_name' => [
                'desc' => 'coach first name',
                'required' => true,
                'min' => 2,
            ],
            'last_name' => [
                'desc' => 'coach last name',
                'required' => true,
                'min' => 2
            ],
            'email' => [
                'desc' => 'coach email address',
                'required' => true,
                'email' => true
            ],
            'focus' => [
                'desc' => 'area of focus',
                'required' => true,
                'min' => 2
            ],
            'facebook_profile' => [
                'desc' => 'facebook profile',
                'required' => true
            ],
            'twitter_profile' => [
                'desc' => 'twitter profile',
                'required' => true
            ],
            'linkedin_profile' => [
                'desc' => 'linkedin profile',
                'required' => true
            ]
        ];

        return $rulesArray;
    }


    /**
     * @method                      getClassDetailsRules
     * @desc                        Rules for valid class details.
     * @return                      array
     */
    public static function getClassDetailsRules()
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
                'max_value' => 35,
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
     * @method                      getPostCategoryRules
     * @desc                        Valid post categories rules. Used in selecting posts by category and validating get parameter.
     * @return                      array
     */
    public static function getPostCategoryRules()
    {
        $rulesArray = [
            'category' => [
                'required' => true,
                'exists' => 'post/p_category'
            ]
        ];
        return $rulesArray;
    }

    /**
     * @method                      getPostTagRules
     * @desc                        Valid post tag rules. Used in selecting posts by tag and validating get parameter.
     * @return                      array
     */
    public static function getPostTagRules()
    {
        $rulesArray = [
            'tag' => [
                'required' => true,
                'exists' => 'post_tag/pt_text'
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
     * @method                      getUsernameRules
     * @desc                        Rules for valid username
     * @return                      array
     */
    private static function getUsernameRules()
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
     * @method                      getUserEmailRules
     * @desc                        Rules for valid email address.
     * @return                      array
     */
    private static function getUserEmailRules()
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
     * @method                      getPasswordRules
     * @desc                        Rules for valid password.
     * @return                      array
     */
    private static function getPasswordRules()
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