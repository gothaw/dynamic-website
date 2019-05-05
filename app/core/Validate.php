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
                    $this->addError("{$items[$item]['desc']} is required.");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':

                            if (strlen($value) < $ruleValue) {
                                $this->addError("{$items[$item]['desc']} must be a minimum of {$ruleValue} characters.");
                            }

                            break;
                        case 'max':

                            if (strlen($value) > $ruleValue) {
                                $this->addError("{$items[$item]['desc']} must be a maximum of {$ruleValue} characters.");
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
                                $this->addError("{$items[$item]['desc']} must include a number.");
                            }

                            break;
                        case 'contains_uppercase':

                            if (strtolower($value) === $value) {
                                $this->addError("{$items[$item]['desc']} must include an uppercase letter.");
                            }

                            break;
                        case 'contains_lowercase':

                            if (strtoupper($value) === $value) {
                                $this->addError("{$items[$item]['desc']} must include an lowercase letter.");
                            }

                            break;
                        case 'forbidden_characters':
                            $forbiddenCharacters = [" ", ",", "'", "%", "`", "\""];
                            foreach ($forbiddenCharacters as $character) {
                                if (strpos($value, $character)) {
                                    $this->addError("{$items[$item]['desc']} cannot include spaces, commas, ', %, ` and \".");
                                }
                            }
                            break;
                        case 'date':
                            $dateArray = explode('-',$value);
                            if(!checkdate($dateArray[1],$dateArray[2],$dateArray[0])){
                                $this->addError("This {$items[$item]['desc']} is invalid.");
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
}