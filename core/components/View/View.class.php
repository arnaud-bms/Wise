<?php
namespace Telco\View;

use Telco\Component\Component;

/**
 * View component
 *
 * @author gdievart <dievartg@gmail.com>
 */
class View extends Component 
{
    
    /**
     * @var CacheDriver 
     */
    protected $_driver;
    
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'driver'
    );
    
    
    /**
     * Init View
     * 
     * @param array $config 
     */
    protected function _init($config)
    {
        switch($config['driver']) {
            case 'smarty':
                $driver = 'Telco\View\Driver\Smarty';
                break;
            default:
                throw new ViewException("Driver '{$config['driver']}' does'nt exists", 400);
        }
        
        $driverConfig = isset($config[$config['driver']]) ? $config[$config['driver']] : null;
        $this->_driver = new $driver($driverConfig);
    }
    
    
    /**
     * Set data list
     * 
     * @param array $dataList 
     */
    public function setDataList($dataList)
    {
        $this->_driver->setDataList($dataList);
    }
    
    
    /**
     * Set data to view
     * 
     * @param string $field
     * @param mixed $value
     */
    public function setData($field, $value)
    {
        $this->_driver->setData($field, $value);
    }
    
    
    /**
     * Get data
     * 
     * @param type $field
     * @return type 
     */
    public function getData($field)
    {
        return $this->_driver->getData($field);
    }
    
    
    /**
     * Return content to stdout 
     * 
     * @param type $template 
     */
    public function display($template)
    {
        $this->_driver->display($template);
    }
    
    
    /**
     * Return content from view
     * 
     * @param type $template 
     * @return string
     */
    public function fetch($template)
    {
        return $this->_driver->fetch($template);
    }
}
