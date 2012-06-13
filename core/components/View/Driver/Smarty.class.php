<?php
namespace Telco\View\Driver;

use Telco\View\Driver\Driver;

/**
 * Driver Smarty
 *
 * @author gdievart
 */
class Smarty extends Driver
{
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'template_dir',
        'compile_dir'
    );
    
    /**
     * @var Smarty Ref to Smarty 
     */
    private $_smarty;
    
    
    /**
     * Init Smarty driver
     * 
     * @param array $config 
     */
    public function __construct($config)
    {
        require_once ROOT_DIR.'/vendor/smarty/libs/Smarty.class.php';
        $this->_smarty = new \Smarty();
        $this->_smarty->template_dir = $config['template_dir'];
        $this->_smarty->compile_dir  = $config['compile_dir'];
    }
    
    
    /**
     * Set data to view driver
     * 
     * @param string $field
     * @param mixed $content 
     */
    public function setData($field, $content)
    {
        $this->_smarty->assign($field, $content);
    }
    
    
    /**
     * Get data setted
     * 
     * @param string $field 
     */
    public function getData($field)
    {
        return $this->_smarty->getTemplateVars($field);
    }
    
    
    /**
     * Return contentto stdout 
     * 
     * @param type $template 
     */
    public function display($template)
    {
        
    }
    
    
    /**
     * Return content from view
     * 
     * @param type $template 
     * @return string
     */
    public function fetch($template)
    {
        return $this->_smarty->fetch($template);
    }
}
