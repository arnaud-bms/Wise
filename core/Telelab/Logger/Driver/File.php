<?php
namespace Telelab\Logger\Driver;

use Telelab\Logger\Driver\Driver;

/**
 * File driver for Logger
 *
 * @author gdievart <dievartg@gmail.com>
 */
class File extends Driver
{
    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'file'
    );

    /**
     * @var string Path to cache folder
     */
    protected $file;

    /**
     * @var handle
     */
    protected $handle;

    /**
     * Init File driver
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->file = $config['file'];
        
        parent::init($config);
    }


    /**
     * Retrieve valid cache
     *
     * @param string $message
     * @param int  $level
     */
    public function log($message, $level)
    {
        if (!is_dir(dirname($this->file))) {
            mkdir(dirname($this->file), 0755, true);
        }

        file_put_contents($this->file, $message, FILE_APPEND);
        // Temporary comment because the logrotate lose handle
        /*$this->initHandle();
        if ($this->handle) {
            fwrite($this->handle, $message);
        }*/
    }


    /**
     * Init handle
     */
    private function initHandle()
    {
        if (!$this->handle) {
            if (!is_dir(dirname($this->file))) {
                mkdir(dirname($this->file), 0755, true);
            }
            $this->handle = fopen($this->file, 'a+');
        }
    }


    /**
     * Close file
     */
    public function __destruct()
    {
        if ($this->handle !== null) {
            fclose($this->handle);
        }
    }
}
