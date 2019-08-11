<?php

/**
 *                              Class Validate
 * @desc                        Primary validation class that uses check method to check the value provided in a form field against validation rules.
 *                              If validation fails an error is added to error array.
 */
class Validate
{
    private $_passed = false;
    private $_errors = [];
    private $_database;

    /**
     *                          Validate constructor.
     * @desc                    Sets database field.
     */
    public function __construct()
    {
        $this->_database = Database::getInstance();
    }

    /**
     * @method                  check
     * @param                   $source {http method as a source of the data to be checked}
     * @param                   $items {array, rules array from ValidationRules}
     * @desc                    Method validate the input form source by looping through the rules array. If a rule is not satisfied an error is added.
     *                          If there are no errors after checking all rules, field _passed is changed to true.
     */
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
                                $this->addError("{$items[$item]['desc']} must be a more than {$ruleValue} characters.");
                            }

                            break;
                        case 'min_value':

                            if($value < $ruleValue) {
                                $this->addError("{$items[$item]['desc']} must be greater than {$ruleValue}.");
                            }

                            break;
                        case 'max':

                            if (strlen($value) > $ruleValue) {
                                $this->addError("{$items[$item]['desc']} must be a less than {$ruleValue} characters.");
                            }

                            break;
                        case 'max_value':

                            if($value > $ruleValue) {
                                $this->addError("{$items[$item]['desc']} must be less than {$ruleValue}.");
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

                            $sql = "SELECT * FROM " . $table . " WHERE " . $column . " = ? LIMIT 1";
                            $query = $this->_database->query($sql, [$value]);

                            if ($query->getResultRowCount()) {
                                $this->addError("{$items[$item]['desc']} already exists");
                            }

                            break;
                        case 'exists':

                            $path = explode('/', $ruleValue);

                            $table = $path[0];
                            $column = $path[1];

                            $sql = "SELECT * FROM " . $table . " WHERE " . $column . " = ? LIMIT 1";
                            $query = $this->_database->query($sql, [$value]);

                            if (!$query->getResultRowCount()) {
                                $this->addError("{$items[$item]['desc']} does not exist. Please select different {$items[$item]['desc']}.");
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
                        case 'future_date':
                            $dateArray = explode('-',$value);
                            if(!checkdate($dateArray[1],$dateArray[2],$dateArray[0])){
                                $this->addError("This {$items[$item]['desc']} is invalid.");
                            }
                            if($value < date('Y-m-d')){
                                $this->addError("This {$items[$item]['desc']} cannot be in the past.");
                            }
                            break;
                        case 'date':
                            $dateArray = explode('-',$value);
                            if(!checkdate($dateArray[1],$dateArray[2],$dateArray[0])){
                                $this->addError("This {$items[$item]['desc']} is invalid.");
                            }
                            break;
                        case 'time':
                            $timeObject = DateTime::createFromFormat("H:i", $value);
                            if(!($timeObject && $timeObject->format("H:i") === $value)){
                                $this->addError("{$items[$item]['desc']} is invalid.");
                            }
                            break;
                        case 'numerical':
                            if(!is_numeric($value)){
                                $this->addError("{$items[$item]['desc']} must be a number.");
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

    /**
     * @method                  addError
     * @param                   $error {string}
     * @desc                    Adds validation error message to the _errors array.
     */
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * @method                  getErrorMessages
     * @desc                    Gets validation errors array.
     * @return                  array
     */
    public function getErrorMessages()
    {
        return $this->_errors;
    }

    /**
     * @method                  getFirstErrorMessage
     * @desc                    Gets first error message from validation error array.
     * @return                  string
     */
    public function getFirstErrorMessage()
    {
        return $this->getErrorMessages()[0];
    }

    /**
     * @method                  checkIfPassed
     * @desc                    Getter for _passed field.
     * @return                  bool
     */
    public function checkIfPassed()
    {
        return $this->_passed;
    }
}