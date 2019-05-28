<?php

class File
{
    private $_file;
    private $_error;

    public function __construct($name = null)
    {
        if(isset($name)){
            $this->_file = $_FILES[$name];
        }
    }

    /**
     * @method                  addError
     * @param                   $error {string}
     * @desc                    Adds validation error message to the _errors array.
     */
    private function setError($error)
    {
        $this->_error = $error;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function getName()
    {
        return $this->_file['name'];
    }

    private function getFileExtension()
    {
        $fileExtension = explode('.', $this->_file['name']);
        return strtolower(end($fileExtension));
    }

    public function exists()
    {
        return ($this->_file['error'] !== 4) ? true : false;
    }

    public function checkIfValid($maxSize, $fileTypes = [])
    {
        if ($this->_file['error'] !== 0) {
            $this->setError("Something went wrong when uploading the file. Please select different one.");
        } else if ($this->_file['size'] > $maxSize * 1000) {
            $this->setError("File size exceeds {$maxSize}kB. Please select smaller file.");
        } else if (!in_array($this->getFileExtension(), $fileTypes)) {
            $this->setError("Invalid file format. Accepted file formats: " . implode(', ', $fileTypes));
        }
        if (!isset($this->_error)) {
            return true;
        }
        return false;
    }

    public function upload($destination){
        move_uploaded_file($this->_file['tmp_name'], $destination);
    }

    public function replace($oldFileDestination, $newFileDestination){
        $this->delete($oldFileDestination);
        $this->upload($newFileDestination);
    }

    public function delete($destination){
        unlink($destination);
    }
}