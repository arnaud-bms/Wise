<?php
namespace Telelab\File;

use Telelab\Component\Component;
use Telelab\File\FileUploadedException;

/**
 * File: Manage files, upload, check extensions ...
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class File extends Component
{

    /**
     * @var string Path to move uploaded file
     */
    private $_uploadedFilePath;

    /**
     * @var array Extension available for upload
     */
    private $_uploadedFileExt = array();

    /**
     * @var int|array Max size
     */
    private $_maxSize;

    /**
     * @var string Current ext uploaded
     */
    private $_currentExt;


    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'path',
        'ext',
    );


    /**
     * @var array mime types
     */
    private $_mimeTypes = array(
        '3gp'   => 'audio/mpeg',
        'gif'   => 'image/gif',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'png'   => 'image/png',
        'mp3'   => 'audio/mpeg',
    );

    /**
     * Init File component
     *
     * @param array $config
     */
    protected function _init($config)
    {
        $this->_uploadedFilePath = $config['path'];
        $this->_uploadedFileExt  = explode(',', $config['ext']);
        if (isset($config['max_size'])) {
            $this->_maxSize = $config['max_size'];
        }
    }


    /**
     * Check uploaded file and return new file path
     *
     * @param string $file
     */
    public function getUploadedFile($file)
    {
        $this->_checkFileUploaded($file);
        $this->_checkExtension($file);
        $this->_checkMaxSize($file);
        return $this->_moveUploadedFile($file);
    }


    /**
     * Check if the file is uploaded
     *
     * @throws FileUploadedException If an error on upload file
     * @param array $file
     */
    private function _checkFileUploaded($file)
    {
        if (!is_uploaded_file($file['tmp_name'])) {
            switch($file['error']){
                case 0:
                    throw new FileUploadedException("An error occurred while sending the file", $file['error']);
                case 1:
                    throw new FileUploadedException("The file is too large to be processed", $file['error']);
                case 2:
                    throw new FileUploadedException("The file is too large to be processed", $file['error']);
                case 3:
                    throw new FileUploadedException("The file was partially uploaded", $file['error']);
                case 4:
                    throw new FileUploadedException("Not file receive", $file['error']);
                default:
                    throw new FileUploadedException("Unknow error", 5);
            }
        }
    }


    /**
     * Check if the file is uploaded
     *
     * @throws FileUploadedException If extension is not available
     * @param array $file
     */
    private function _checkExtension($file)
    {
        $fileInfos = pathinfo($file['name']);

        if (empty($fileInfos['extension']) || !in_array(strtolower($fileInfos['extension']), $this->_uploadedFileExt)) {
            throw new FileUploadedException("Extension not allowed", 6);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if (isset($this->_mimeTypes[$fileInfos['extension']]) && $this->_mimeTypes[$fileInfos['extension']] !== finfo_file($finfo, $file['tmp_name'])) {
            throw new FileUploadedException("Extension not allowed", 6);
        }

        $this->_currentExt = $fileInfos['extension'];
    }


    /**
     * Check if the size file
     *
     * @throws FileUploadedException If size is too large
     * @param array $file
     */
    private function _checkMaxSize($file)
    {
        if ($this->_maxSize === null) {
            return true;
        }

        if (is_array($this->_maxSize) && isset($this->_maxSize[$this->_currentExt])) {
            $maxSize = $this->_maxSize[$this->_currentExt];
        } else {
            $maxSize = $this->_maxSize;
        }

        if ($file['size'] > $maxSize) {
            throw new FileUploadedException("File size is too large", 8);
        }
    }


    /**
     * Move uploaded file
     *
     * @throws FileUploadedException If an error on move file
     * @param array $file
     * @return filename
     */
    private function _moveUploadedFile($file)
    {
        $filenameUploaded = $this->_uploadedFilePath.'/'.date('Y-m-d').'_'.uniqid().'.'. $this->_currentExt;
        if (!is_dir($this->_uploadedFilePath)) {
            mkdir($this->_uploadedFilePath, 0775, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $filenameUploaded)) {
            throw new FileUploadedException("Error on upload file", 7);
        }

        return $filenameUploaded;
    }


    /**
     * Write file
     *
     * @param string $file
     * @param string $content
     */
    public static function putContents($file, $content)
    {
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0775, true);
        }

        return file_put_contents($file, $content);
    }
}
