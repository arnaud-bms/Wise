<?php
namespace Telelab\View\Driver;

use Telelab\View\Driver\Driver;

/**
 * Driver Php
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Php extends Driver
{
    /**
     * @var StdObject viewData
     */
    private $viewData;

    /**
     * @var string Path to template
     */
    private $tplDir;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'template_dir',
    );


    /**
     * Init view
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->viewData = new \stdClass();
        $this->tplDir   = $config['template_dir'];
    }


    /**
     * Set data to view driver
     *
     * @param string $field
     * @param mixed $content
     */
    public function setData($field, $content)
    {
        $this->viewData->$field = $content;
    }


    /**
     * Get data setted
     *
     * @param string $field
     */
    public function getData($field)
    {
        return $this->viewData->$field;
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
        $view = $this->viewData;
        include $this->tplDir."/".$template;
    }
}
