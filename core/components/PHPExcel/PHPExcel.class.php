<?php
namespace Telelab\PHPExcel;

use Telelab\Component\ComponentStatic;

/**
 * PHPExcel: read and write files excel document, pdf, html ....
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class PHPExcel extends ComponentStatic
{


    /**
     * Init phpExcel
     *
     * @param array $config
     */
    protected static function _init($config)
    {
        require_once ROOT_DIR.'/vendor/phpexcel/Classes/PHPExcel/IOFactory.php';
    }


    /**
     * Load file
     *
     * @param string $file
     * @throws PHPExcel_Reader_Exception Unable to identify a reader for this file
     * @return PHPExcel
     */
    public static function load($file)
    {
        return \PHPExcel_IOFactory::load($file);
    }
}
