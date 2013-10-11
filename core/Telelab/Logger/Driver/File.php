<?php
namespace Telelab\Logger\Driver;

use Telelab\Logger\Driver\Driver;

/**
 * File driver for Logger
 *
 * @author gdievart <g.dievart@telemaque.fr>
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
    protected $_file;

    /**
     * @var handle
     */
    protected $_handle;

    /**
     * Init File driver
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->_file = $config['file'];
        
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
        if (!is_dir(dirname($this->_file))) {
            mkdir(dirname($this->_file), 0755, true);
        }

        file_put_contents($this->_file, $message, FILE_APPEND);
        // Temporary comment because the logrotate lose handle
        /*$this->initHandle();
        if ($this->_handle) {
            fwrite($this->_handle, $message);
        }*/
    }


    /**
     * Init handle
     */
    private function initHandle()
    {
        if (!$this->_handle) {
            if (!is_dir(dirname($this->_file))) {
                mkdir(dirname($this->_file), 0755, true);
            }
            $this->_handle = fopen($this->_file, 'a+');
        }
    }


    /**
     * Close file
     */
    public function __destruct()
    {
        if ($this->_handle !== null) {
            fclose($this->_handle);
        }
    }
}
