<?php
namespace Wise\File;

use Wise\Component\Component;
use Wise\File\FileUploadedException;

/**
 * File: Manage files, upload, check extensions ...
 *
 * @author gdievart <dievartg@gmail.com>
 */
class File extends Component
{

    /**
     * @var string Path to move uploaded file
     */
    private $uploadedFilePath;

    /**
     * @var array Extension available for upload
     */
    private $uploadedFileExt = array();

    /**
     * @var int|array Max size
     */
    private $maxSize;

    /**
     * @var string Current ext uploaded
     */
    private $currentExt;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'path',
        'ext',
    );

    /**
     * @var array mime types
     */
    private $mimeTypes = array(
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
    protected function init($config)
    {
        $this->uploadedFilePath = $config['path'];
        $this->uploadedFileExt  = explode(',', $config['ext']);
        if (isset($config['max_size'])) {
            $this->maxSize = $config['max_size'];
        }
    }

    /**
     * Check uploaded file and return new file path
     *
     * @param string $file
     */
    public function getUploadedFile($file)
    {
        $this->checkFileUploaded($file);
        $this->checkExtension($file);
        $this->checkMaxSize($file);

        return $this->moveUploadedFile($file);
    }

    /**
     * Check if the file is uploaded
     *
     * @throws FileUploadedException If an error on upload file
     * @param  array                 $file
     */
    private function checkFileUploaded($file)
    {
        if (!is_uploaded_file($file['tmp_name'])) {
            switch ($file['error']) {
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
     * @param  array                 $file
     */
    private function checkExtension($file)
    {
        $fileInfos = pathinfo($file['name']);

        if (empty($fileInfos['extension']) || !in_array(strtolower($fileInfos['extension']), $this->uploadedFileExt)) {
            throw new FileUploadedException("Extension not allowed", 6);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if (isset($this->mimeTypes[$fileInfos['extension']])
            && $this->mimeTypes[$fileInfos['extension']] !== finfo_file($finfo, $file['tmp_name'])) {
            throw new FileUploadedException("Extension not allowed", 6);
        }

        $this->currentExt = $fileInfos['extension'];
    }

    /**
     * Check if the size file
     *
     * @throws FileUploadedException If size is too large
     * @param  array                 $file
     */
    private function checkMaxSize($file)
    {
        if ($this->maxSize === null) {
            return true;
        }

        if (is_array($this->maxSize) && isset($this->maxSize[$this->currentExt])) {
            $maxSize = $this->maxSize[$this->currentExt];
        } else {
            $maxSize = $this->maxSize;
        }

        if ($file['size'] > $maxSize) {
            throw new FileUploadedException("File size is too large", 8);
        }
    }

    /**
     * Move uploaded file
     *
     * @throws FileUploadedException If an error on move file
     * @param  array                 $file
     * @return filename
     */
    private function moveUploadedFile($file)
    {
        $filenameUploaded = $this->uploadedFilePath.'/'.date('Y-m-d').'_'.uniqid().'.'. $this->currentExt;
        if (!is_dir($this->uploadedFilePath)) {
            mkdir($this->uploadedFilePath, 0775, true);
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