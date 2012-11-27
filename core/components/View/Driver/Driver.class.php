<?php
namespace Telco\View\Driver;

use Telco\Component\Component;

/**
 * AbstractDriver
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver extends Component
{

    public function setDataList($dataList)
    {
        foreach ($dataList as $field => $value) {
            $this->setData($field, $value);
        }
    }

    abstract public function setData($field, $value);

    abstract public function getData($field);

    abstract public function display($template);

    abstract public function fetch($template);
}
