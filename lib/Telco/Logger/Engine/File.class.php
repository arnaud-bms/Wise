<?php
namespace Telco\Logger\Engine;

use Telco\Component\Component;
use Telco\Logger\Engine\EngineInterface;

/**
 * File engine for Logger
 *
 * @author gdievart
 */
class File extends Component implements EngineInterface 
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
     * Init File engine
     * 
     * @param array $config 
     */
    public function _init($config)
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
