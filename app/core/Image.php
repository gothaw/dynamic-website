<?php

class Image
{
    private $_file;
    private $_error;

    /**
     *                          Image constructor.
     * @param                   $name {name of the image in $_FILE super global}
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
     * @method                  getImageExtension
     * @desc                    Returns image extension from _file field.
     * @return                  string
     */
    public function getImageExtension()
    {
        $imageExtension = explode('.', $this->_file['name']);
        return strtolower(end($imageExtension));
    }

    /**
     * @method                  exists
     * @desc                    Checks if image has been upload i.e. upload error in $_FILE is different than 4.
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
     * @desc                    Validates uploaded image. Checks if there is no $_FILE error, image size is not exceeded and image has required extension.
     * @return                  bool
     */
    public function checkIfValid($maxSize, $fileTypes = [])
    {
        if ($this->_file['error'] !== 0) {
            $this->setError("Something went wrong when uploading the image. Please select different one.");
        } else if ($this->_file['size'] > $maxSize * 1000) {
            $this->setError("Image size exceeds {$maxSize}kB. Please select smaller image.");
        } else if (!in_array($this->getImageExtension(), $fileTypes)) {
            $this->setError("Invalid image format. Accepted file formats: " . implode(', ', $fileTypes));
        }
        if (!isset($this->_error)) {
            return true;
        }
        return false;
    }

    /**
     * @method                  upload
     * @param                   $destination
     * @desc                    Uploads image using move_uploaded_file.
     */
    public function upload($destination){
        move_uploaded_file($this->_file['tmp_name'], $destination);
    }

    /**
     * @method                  replace
     * @param                   $oldImageDestination {image url}
     * @param                   $newImageDestination {image url}
     * @desc                    Deletes one image and adds a new one.
     */
    public function replace($oldImageDestination, $newImageDestination){
        $this->delete($oldImageDestination);
        $this->upload($newImageDestination);
    }

    /**
     * @method                  delete
     * @param                   $destination {image url}
     * @desc                    Deletes image using unlink.
     */
    public function delete($destination){
        unlink($destination);
    }
}