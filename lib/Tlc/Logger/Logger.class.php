<?php
namespace Tlc\Logger;

use Tlc\Component\Component;

/**
 * Format data from array to csv, json, xml, serialize ...
 *
 * @author gdievart
 */
class Logger extends Component 
{
    /**
     * @staticvar int Log level 
     */
    const LOG_DEBUG = 0;
    const LOG_INFO = 1;
    const LOG_ERROR = 2;
    const LOG_CRIT = 3;
    
    /**
     * @var array list level 
     */
    protected $_listLevel = array(
        0 => 'DEBUG',
        1 => 'INFO',
        2 => 'ERROR',
        3 => 'CRIT'
    );
    
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'engine',
        'enable'
    );
    
    /**
     * @var engine Ref to engine
     */
    protected $_engine;
    
    /**
     * @var boolean Enable log
     */
    protected $_enable;
    
    /**
     * Init logger
     * 
     * @param array $config
     */
    protected function _init($config)
    {
        $class = 'Tlc\Logger\Engine\\' . ucfirst($config['engine']);
        $this->_engine = new $class($config[$config['engine']]);
        
        $this->_enable = (boolean)$config['enable'];
    }
    
    
    /**
     * Write message
     * 
     * @param string $message
     * @param int $level 
     */
    public function log($message, $level = self::LOG_INFO)
    {
        if($this->_enable) {
            $message = date('Y-m-d H:i:s') . ' [' . $this->_listLevel[$level] . '] ' . $message;
            $this->_engine->log($message, $level);
        }
    }
}
