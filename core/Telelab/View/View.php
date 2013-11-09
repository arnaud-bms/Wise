<?php
namespace Wise\View;

use Wise\Component\Component;

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
    protected $driver;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'driver'
    );

    /**
     * Init View
     *
     * @param array $config
     */
    protected function init($config)
    {
        switch ($config['driver']) {
            case 'smarty':
                $driver = 'Wise\View\Driver\Smarty';
                break;
            case 'php':
                $driver = 'Wise\View\Driver\Php';
                break;
            default:
                throw new ViewException("Driver '{$config['driver']}' does'nt exists", 400);
        }

        $driverConfig = isset($config[$config['driver']]) ? $config[$config['driver']] : null;
        $this->driver = new $driver($driverConfig);
    }

    /**
     * Set data list
     *
     * @param array $dataList
     */
    public function setDataList($dataList)
    {
        $this->driver->setDataList($dataList);
    }

    /**
     * Set data to view
     *
     * @param string $field
     * @param mixed  $value
     */
    public function setData($field, $value)
    {
        $this->driver->setData($field, $value);
    }

    /**
     * Get data
     *
     * @param  type $field
     * @return type
     */
    public function getData($field)
    {
        return $this->driver->getData($field);
    }

    /**
     * Return content to stdout
     *
     * @param type $template
     */
    public function display($template)
    {
        $this->driver->display($template);
    }

    /**
     * Return content from view
     *
     * @param  type   $template
     * @return string
     */
    public function fetch($template)
    {
        return $this->driver->fetch($template);
    }
}
