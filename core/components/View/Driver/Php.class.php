<?php
namespace Telelab\View\Driver;

use Telelab\View\Driver\Driver;

/**
 * Driver Php
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Php extends Driver
{
    /**
     * @var StdObject viewData
     */
    private $_viewData;

    /**
     * @var string Path to template
     */
    private $_tplDir;

    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'template_dir',
    );


    /**
     * Init view
     *
     * @param array $config
     */
    protected function _init($config)
    {
        $this->_viewData = new \stdClass();
        $this->_tplDir   = $config['template_dir'];
    }


    /**
     * Set data to view driver
     *
     * @param string $field
     * @param mixed $content
     */
    public function setData($field, $content)
    {
        $this->_viewData->$field = $content;
    }


    /**
     * Get data setted
     *
     * @param string $field
     */
    public function getData($field)
    {
        return $this->_viewData->$field;
    }


    /**
     * Return content to stdout
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
        global $view;
        $view = $this->_viewData;
        include $this->_tplDir."/".$template;
    }
}
