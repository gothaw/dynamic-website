<?php

class File
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function exists()
    {
        return ($_FILES[$this->_name]['error'] !== 4) ? true : false;
    }
}