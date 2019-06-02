<?php

class File
{
    private $_file;
    private $_error;

    /**
     *                          File constructor.
     * @param                   $name {name of the file in $_FILE super global}
     * @desc                    Sets _file field.
     */
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

    /**
     * @method                  getError
     * @desc                    Gets error message.
     * @return                  string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @method                  getName
     * @desc                    Returns file name.
     * @return                  string
     */
    public function getName()
    {
        return $this->_file['name'];
    }

    /**
     * @method                  getFileExtension
     * @desc                    Returns file extension from _file field.
     * @return                  string
     */
    public function getFileExtension()
    {
        $fileExtension = explode('.', $this->_file['name']);
        return strtolower(end($fileExtension));
    }

    /**
     * @method                  exists
     * @desc                    Checks if file has been upload i.e. upload error in $_FILE is different than 4.
     * @return                  bool
     */
    public function exists()
    {
        return ($this->_file['error'] !== 4) ? true : false;
    }

    /**
     * @method                  checkIfValid
     * @param                   $maxSize {in kB}
     * @param                   $fileTypes {array of strings}
     * @desc                    Validates uploaded file. Checks if there is no $_FILE error, file size is not exceeded and file has required extension.
     * @return                  bool
     */
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

    /**
     * @method                  upload
     * @param                   $destination
     * @desc                    Uploads file using move_uploaded_file.
     */
    public function upload($destination){
        move_uploaded_file($this->_file['tmp_name'], $destination);
    }

    /**
     * @method                  replace
     * @param                   $oldFileDestination {file url}
     * @param                   $newFileDestination {file url}
     * @desc                    Deletes one file and adds a new one.
     */
    public function replace($oldFileDestination, $newFileDestination){
        $this->delete($oldFileDestination);
        $this->upload($newFileDestination);
    }

    /**
     * @method                  delete
     * @param                   $destination {file url}
     * @desc                    Deletes file using unlink.
     */
    public function delete($destination){
        unlink($destination);
    }
}