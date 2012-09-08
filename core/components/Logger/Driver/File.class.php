<?php
namespace Telco\Logger\Driver;

use Telco\Logger\Driver\AbstractDriver;
use Telco\Logger\LoggerException;

/**
 * File driver for Logger
 *
 * @author gdievart <dievartg@gmail.com>
 */
class File extends AbstractDriver
{
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
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
    protected function _init($config)
    {
        $this->_file = $config['file'];
    }
    
    
    /**
     * Retrieve valid cache
     * 
     * @param string $message
     * @param int  $level
     */
    public function log($message, $level)
    {
        $this->_initHandle();
        fwrite($this->_handle, $message);
    }
    
    
    /**
     * Init handle
     */
    private function _initHandle()
    {
        if($this->_handle === null) {
            $this->_handle = fopen($this->_file, 'a+');
        }
    }
    
    
    /**
     * Close file
     */
    public function __destruct()
    {
        if($this->_handle !== null) {
            fclose($this->_handle);
        }
    }
}
