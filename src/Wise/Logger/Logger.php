<?php
namespace Wise\Logger;

use Wise\Component\Component;

/**
 * Class \Wise\Logger\Logger
 * 
 * This class is an interface of Monolog
 * 
 * @author gdievart <dievartg@gmail.com>
 */
class Logger extends Component
{
    /**
     * Reference to Monolog
     *
     * @var \Monolog\Logger
     */
    private $logger;
    
    /**
     * Log format
     *
     * @var \Monolog\Formatter\LineFormatter
     */
    private $formatter;
    
    /**
     * List log level
     *
     * @var array
     */
    private $logLevel = array(
        'debug'     => \Monolog\Logger::DEBUG,
        'info'      => \Monolog\Logger::INFO,
        'notice'    => \Monolog\Logger::NOTICE,
        'warning'   => \Monolog\Logger::WARNING,
        'error'     => \Monolog\Logger::ERROR,
        'critical'  => \Monolog\Logger::CRITICAL,
        'alert'     => \Monolog\Logger::ALERT,
        'emergency' => \Monolog\Logger::EMERGENCY,
    );
    
    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'name',
        'handler',
        'date_format',
        'format'
    );
    
    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $this->logger    = new \Monolog\Logger($config['name']);
        $this->formatter = new \Monolog\Formatter\LineFormatter(
            (string) $config['format'],
            (string) $config['date_format']
        );
        
        $this->initHandler($config['handler']);
    }
    
    /**
     * Initialize the handlers
     * 
     * @param array $handlers
     */
    private function initHandler($handlers)
    {
        foreach ($handlers as $handler) {
            if (empty($handler['type']) || empty($handler['log_level'])) {
                throw new Exception('The handler require the fiels "type" and "log_level"', 0);
            }
            
            $options = !empty($handler['options']) ? $handler['options'] : array();
            $this->addHandler($handler['type'], $handler['log_level'], $options);
        }
    }
    
    /**
     * Add a Monolog\Handler
     * 
     * @param string $handler
     * @param string $logLevel
     * @param array  $options
     * @throws Exception If the handler or the logLevel don't exist
     */
    public function addHandler($handler, $logLevel, $options = null)
    {
        $logLevel  = \Wise\String\String::lower($logLevel);
        $classname = '\Monolog\Handler\\'.ucfirst($handler).'Handler';
        if (!class_exists($classname, true)) {
            throw new Exception('The handler "'.$handler.'" is not valid', 0);
        }
        
        if (empty($this->logLevel[$logLevel])) {
            throw new Exception('The log level "'.$logLevel.'" is not valid', 0);
        }
        
        $handler = new \ReflectionClass($classname);
        
        $args = (array) $options;
        $args[] = $this->logLevel[$logLevel];
        $handler = $handler->newInstanceArgs($args);
        
        $handler->setFormatter($this->formatter);
        
        $this->logger->pushHandler($handler); 
    }
    
    /**
     * Add a callable who is call after a log write
     * 
     * @param callable $processor
     */
    public function addProcessor($processor)
    {
        if (!is_callable($processor)) {
            throw new Exception('The "'.var_export($processor, true).'" is not callable', 0);
        }
        
        $this->logger->pushProcessor($processor);
    }
    
    /**
     * Write an emergency message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function emergency($message, $context = array())
    {
        $this->logger->addEmergency($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write an alert message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function alert($message, $context = array())
    {
        $this->logger->addAlert($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write a critical message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function critical($message, $context = array())
    {
        $this->logger->addCritical($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write an error message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function error($message, $context = array())
    {
        $this->logger->addError($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write a warning message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function warning($message, $context = array())
    {
        $this->logger->addWarning($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write a notice message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function notice($message, $context = array())
    {
        $this->logger->addNotice($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write an info message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function info($message, $context = array())
    {
        $this->logger->addInfo($this->psrLog($message, $context), $context);
    }
    
    /**
     * Write a debug message
     * 
     * @param string $message Message to write
     * @param array  $context Context
     */
    public function debug($message, $context = array())
    {
        $this->logger->addDebug($this->psrLog($message, $context), $context);
    }
    
    /**
     * Temporary method (wait the processor PsrLogMessageProcessor)
     * 
     * @param string $message
     * @param array  $context
     * @return string Message
     */
    private function psrLog($message, $context)
    {
        if (false === strpos($message, '{')) {
            return $message;
        }

        $replacements = array();
        foreach ($context as $key => $val) {
            $replacements['{'.$key.'}'] = $val;
        }

        $message = strtr($message, $replacements);

        return $message;
    }
}
