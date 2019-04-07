<?php

class Validate
{
    private $_passed = false;
    private $_errors = [];
    private $_database = null;

    public function __construct()
    {
        $this->_database = Database::getInstance();
    }

    public function check($source, $items = [])
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $ruleValue) {

                $value = $source[$item];
                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$items[$item]['name']} is required.");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':

                            if (strlen($value) < $ruleValue) {
                                $this->addError("{$items[$item]['name']} must be a minimum of {$ruleValue} characters.");
                            }

                            break;
                        case 'max':

                            if (strlen($value) > $ruleValue) {
                                $this->addError("{$items[$item]['name']} must be a maximum of {$ruleValue} characters.");
                            }

                            break;
                        case 'matches':

                            if ($value !== $source[$ruleValue]) {
                                $this->addError("{$ruleValue}s do not match.");
                            }

                            break;
                        case 'unique':

                            $path = explode('/', $ruleValue);

                            $table = $path[0];
                            $column = $path[1];

                            $query = $this->_database->select($table, [$column, '=', $value]);

                            if ($query->getResultRowCount()) {
                                $this->addError("{$item} already exists");
                            }

                            break;
                        case 'email':

                            $check = filter_var($value, FILTER_VALIDATE_EMAIL);
                            if (!$check) {
                                $this->addError("This is not a valid email.");
                            }

                            break;
                        case 'contains_numerical':

                            $check = preg_match('/\\d/', $value);
                            if (!$check) {
                                $this->addError("{$items[$item]['name']} must include a number.");
                            }

                            break;
                        case 'contains_uppercase':

                            if (strtolower($value) === $value) {
                                $this->addError("{$items[$item]['name']} must include an uppercase letter.");
                            }

                            break;
                        case 'contains_lowercase':

                            if (strtoupper($value) === $value) {
                                $this->addError("{$items[$item]['name']} must include an lowercase letter.");
                            }

                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function getErrorMessages()
    {
        return $this->_errors;
    }

    public function getFirstErrorMessage()
    {
        return $this->getErrorMessages()[0];
    }

    public function checkIfPassed()
    {
        return $this->_passed;
    }

    public function getValidUserRules()
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
}