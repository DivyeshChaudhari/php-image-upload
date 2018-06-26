<?php
namespace PHP\Core;
use Exception;

class ImageUpload
{
    private $imageType;

    private $imageSize;

    private $imageExtension;

    private $tmpPath;

    private $mimeType;

    private $uploadPath;

    private $invalidFiles;

    private $uploadedFiles;

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getMimeType()
    {
        if (empty($mimeType)) {
            $this->mimeType = array('image/jpeg', 'image/gif', 'image/png', 'image/jpg');
        }
        return $this->mimeType;
    }

    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
    }

    public function getImageType()
    {
        if (empty($imageType)) {
            $this->imageType = array("jpeg", "png", "jpg", "gif");
        }
        return $this->imageType;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function upload($fileName)
    {
        $fileInfo = array();
        $invalidFiles = array();
        $errorCount = 0;
        $successCount = 0;
        try {
            if (empty($this->uploadPath)) {
                throw new Exception("Please set file upload path using setUploadPath('path/to/upload') function.");
            } else {
                if (!file_exists($this->uploadPath)) {
                    mkdir($this->uploadPath, 0777, true);
                }
                for ($i = 0; $i < count($_FILES[$fileName]['name']); $i++) {
                    $this->imageSize = getimagesize($_FILES[$fileName]["tmp_name"][$i]);
                    $this->imageExtension = basename($_FILES[$fileName]["name"][$i]);
                    $this->tmpPath = $_FILES[$fileName]["tmp_name"][$i];
                    if ($this->imageSize !== false && $this->tmpPath !== "") {
                        $fileMimeType = mime_content_type($_FILES[$fileName]['tmp_name'][$i]);                        
                        if (in_array($fileMimeType, $this->getMimeType())) {
                            $imageFileType = strtolower(pathinfo($this->imageExtension, PATHINFO_EXTENSION));                                                        
                            if (in_array($imageFileType, $this->getImageType())) {                                
                                $name = date('dmYHis') . '-' . $_FILES[$fileName]['name'][$i];
                                $path = $this->uploadPath . $name;
                                if (move_uploaded_file($this->tmpPath, $path)) {
                                    $fileInfo[$successCount] = array('imgName' => $this->imageExtension);
                                    $successCount++;
                                }
                            } else {
                                $invalidFiles[$errorCount] = array('fileName' => $_FILES[$fileName]["name"][$i]);
                                $errorCount++;
                            }
                        } else {
                            $invalidFiles[$errorCount] = array('fileName' => $_FILES[$fileName]["name"][$i]);
                            $errorCount++;
                        }
                    } else {
                        $invalidFiles[$errorCount] = array('fileName' => $_FILES[$fileName]["name"][$i]);
                        $errorCount++;
                    }
                }
                $this->invalidFiles = $invalidFiles;
                $this->uploadedFiles = $fileInfo;
                $results = array('fileInfo' => $fileInfo, 'error' => $error, 'success' => $success);
                return $results;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function displayInvalidFiles()
    {
        if (sizeof($this->invalidFiles) > 0) {
            for ($i = 0; $i < sizeof($this->invalidFiles); $i++) {
                echo "<br/>Invalid File : " . $this->invalidFiles[$i]['fileName'];
            }
        }
    }

    public function displayUploadedFiles()
    {
        if (sizeof($this->uploadedFiles) > 0) {
            for ($i = 0; $i < sizeof($this->uploadedFiles); $i++) {
                echo "<br/>Uploaded File : " . $this->uploadedFiles[$i]['imgName'];
            }
        }
    }
}
