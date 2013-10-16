<?php
namespace Telelab\View\Driver;

use Telelab\View\Driver\Driver;

/**
 * Driver Smarty
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Smarty extends Driver
{
    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'template_dir',
        'compile_dir'
    );

    /**
     * @var Smarty Ref to Smarty
     */
    private $smarty;


    /**
     * Init Smarty driver
     *
     * @param array $config
     */
    public function init($config)
    {
        require_once ROOT_DIR.'/vendor/smarty/libs/Smarty.class.php';
        $this->smarty = new \Smarty();
        $this->smarty->template_dir = $config['template_dir'];
        $this->smarty->compile_dir  = $config['compile_dir'];
    }


    /**
     * Set data to view driver
     *
     * @param string $field
     * @param mixed $content
     */
    public function setData($field, $content)
    {
        $this->smarty->assign($field, $content);
    }


    /**
     * Get data setted
     *
     * @param string $field
     */
    public function getData($field)
    {
        return $this->smarty->getTemplateVars($field);
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
        return $this->smarty->fetch($template);
    }
}
