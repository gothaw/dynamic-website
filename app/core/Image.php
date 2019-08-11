<?php

/**
 *                              Class Image
 * @desc                        Class used to instantiate image from $_FILES super global. It includes methods to validate image, upload, delete and replace images.
 *                              Additionally, includes a method to create an image thumbnail.
 */
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
        if (isset($name)) {
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
     * @method                  getImageWidth
     * @desc                    Returns image width using getimagesize function.
     */
    public function getImageWidth()
    {
        $sourceProperties = getimagesize($this->_file['tmp_name']);
        return $sourceProperties[0];
    }

    /**
     * @method                  getImageHeight
     * @desc                    Returns image width using getimagesize function.
     */
    public function getImageHeight()
    {
        $sourceProperties = getimagesize($this->_file['tmp_name']);
        return $sourceProperties[1];
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
     * @param                   $destination {url in a dist folder}
     * @desc                    Uploads image using move_uploaded_file.
     */
    public function upload($destination)
    {
        move_uploaded_file($this->_file['tmp_name'], $destination);
    }

    /**
     * @method                  replace
     * @param                   $oldImageDestination {image url in a dist folder}
     * @param                   $newImageDestination {image url in a dist folder}
     * @desc                    Deletes one image and adds a new one.
     */
    public function replace($oldImageDestination, $newImageDestination)
    {
        $this->delete($oldImageDestination);
        $this->upload($newImageDestination);
    }

    /**
     * @method                  delete
     * @param                   $destination {image url in a dist folder}
     * @desc                    Deletes image using unlink.
     */
    public function delete($destination)
    {
        unlink($destination);
    }

    /**
     * @method                  createThumbnail
     * @param                   $width {int}
     * @param                   $height {int}
     * @param                   $uploadPath {image url}
     * @desc                    Method creates a thumbnail from images stored in $_FIlES super global. It supports 'jpg', 'jpeg', 'png' and 'gif' images.
     *                          It also uploads the image to the server using move_upload_file.
     *                          Image thumbnail to be created before uploading main image.
     */
    public function createThumbnail($width, $height, $uploadPath)
    {
        $fileName = $this->_file['tmp_name'];

        $imageType = $this->getImageExtension();
        $imageWidth = $this->getImageWidth();
        $imageHeight = $this->getImageHeight();

        switch ($imageType) {
            case 'jpg':
                $resourceType = imagecreatefromjpeg($fileName);
                $thumbnailLayer = $this->resizeImageFromIdentifier($resourceType, $width, $height, $imageWidth, $imageHeight);
                $thumbnail = imagejpeg($thumbnailLayer, $uploadPath);
                break;
            case 'jpeg':
                $resourceType = imagecreatefromjpeg($fileName);
                $thumbnailLayer = $this->resizeImageFromIdentifier($resourceType, $width, $height, $imageWidth, $imageHeight);
                $thumbnail = imagejpeg($thumbnailLayer, $uploadPath);
                break;
            case 'png':
                $resourceType = imagecreatefrompng($fileName);
                $thumbnailLayer = $this->resizeImageFromIdentifier($resourceType, $width, $height, $imageWidth, $imageHeight);
                $thumbnail = imagepng($thumbnailLayer, $uploadPath);
                break;
            case 'gif':
                $resourceType = imagecreatefromgif($fileName);
                $thumbnailLayer = $this->resizeImageFromIdentifier($resourceType, $width, $height, $imageWidth, $imageHeight);
                $thumbnail = imagegif($thumbnailLayer, $uploadPath);
                break;
        }
        if (isset($thumbnail)) {
            move_uploaded_file($thumbnail, $uploadPath);
        }
    }

    /**
     * @method                  resizeImageFromIdentifier
     * @param                   $resourceType {image identifier obtained from imagecreatefromjpeg, imagecreatedfrompng or imagecreatedfromgif)
     * @param                   $resizeWidth {int}
     * @param                   $resizeHeight {int}
     * @param                   $imageWidth {int}
     * @param                   $imageHeight {int}
     * @desc                    Resizes image from $resourceType by coping it to new image layer (created with imagecreatetrue color).
     * @return                  false|resource
     */
    private function resizeImageFromIdentifier($resourceType, $resizeWidth, $resizeHeight, $imageWidth, $imageHeight)
    {
        $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
        imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $imageWidth, $imageHeight);
        return $imageLayer;
    }
}