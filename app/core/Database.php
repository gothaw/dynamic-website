<?php

class Database
{
    private static $_instance   = null;

    //PDO object instance variables
    private $_host;
    private $_user;
    private $_password;
    private $_databaseName;
    private $_pdo;
    //Other instance variables
    private $_error             = false;
    private $_query             = null;
    private $_result            = null;
    private $_resultRowCount    = 0;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        try {
            $this->_host = Config::get('mysql/host');
            $this->_user = Config::get('mysql/username');
            $this->_password = Config::get('mysql/password');
            $this->_databaseName = Config::get('mysql/db_name');
            $this->_pdo = new PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_databaseName, $this->_user, $this->_password);
        } catch (PDOException $e) {
            // redirect to error page
            exit("Something went wrong. It is our fault. Sorry. = (");
        }
    }

    /**
     * @method              getInstance
     * @desc                Static method that creates an instance of the database or gets the instance of the database if it already has been created.
     *                      Singleton pattern.
     * @return              Database|null
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    /**
     * @method              query
     * @param               $sql {an sql query}
     * @param               $parameters {an array of parameters that require to be bound in a prepare statement}
     * @desc                Method prepares a query statement by looping through the $parameters array.
     *                      The statement is executed and method retrieves the result as an associative array and assigns it to the $_result.
     * @return              $this
     */
    public function query($sql, $parameters = [])
    {
        // Resetting error to false after a previous query
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            if (count($parameters)) {
                $i = 1;
                foreach ($parameters as $parameter) {
                    if(is_integer($parameter)){
                        $this->_query->bindValue($i, $parameter, PDO::PARAM_INT);
                    }else{
                        $this->_query->bindValue($i, $parameter);
                    }
                    $i++;
                }
            }
            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                $this->_resultRowCount = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    /**
     * @method              getResult
     * @desc                Gets query result.
     * @return              array
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     * @method              getResultSingleRecord
     * @desc                Gets a single (first) record from query result.
     * @return              array
     */
    public function getResultSingleRecord(){
        return $this->getResult()[0];
    }

    /**
     * @method              getResultRowCount
     * @desc                Gets row count of a query.
     * @return              int
     */
    public function getResultRowCount(){
        return $this->_resultRowCount;
    }

    /**
     * @method              getQueryError
     * @desc                Gets query error.
     * @return              bool
     */
    public function getQueryError()
    {
        return $this->_error;
    }

    /**
     * @method              simpleQuery
     * @param               $action {SELECT *, DELETE}
     * @param               $table {table name in database}
     * @param               $where {array made of 3 elements, that is a field, an operator and a value e.g ['username','=','alex']}
     * @desc                Method invoked in select and delete methods e.g SELECT * FROM users WHERE username = 'alex'
     * @return              $this|bool
     */
    public function simpleQuery($action, $table, $where = []) {
        // $where requires 3 fields that is a field, an operator and a value
        if(count($where) === 3){
            $operators = ['=','>','<','>=','<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)){

                $sql = "{$action} FROM {$table} WHERE {$field} ${operator} ?;";

                $this->query($sql, [$value]);

                if(!$this->getQueryError()){
                    return $this;
                }
            }
        }
        return false;
    }

    /**
     * @method              select
     * @param               $table {table name in database}
     * @param               $where {array made of 3 elements, that is a field, an operator and a value e.g ['username','=','alex']}
     * @desc                Method invokes simpleQuery method to carry out SELECT query e.g SELECT * FROM users WHERE username = 'alex'
     * @return              bool|$this
     */
    public function select($table, $where){
        return $this->simpleQuery('SELECT *', $table, $where);
    }

    /**
     * @method              delete
     * @param               $table {table name in database}
     * @param               $where {array made of 3 elements, that is a field, an operator and a value e.g ['username','=','alex']}
     * @desc                Method invokes simpleQuery method to carry out DELETE query e.g DELETE FROM users WHERE id = '125'
     * @return              bool|$this
     */
    public function delete($table,$where){
        return $this->simpleQuery('DELETE',$table,$where);
    }











    public function insert($table, $fields = array()){
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach($fields as $field){
            $values .= "?";
            if($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`". implode("`,`",$keys) . "`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->getQueryError()){
            return true;
        }
        return false;
    }


    public function update($table, $id, $fields){
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->getQueryError()){
            return true;
        }
        return false;
    }



}