<?php
namespace Telelab\PHPExcel;

use Telelab\Component\ComponentStatic;

/**
 * PHPExcel: read and write files excel document, pdf, html ....
 *
 * @author gdievart <dievartg@gmail.com>
 */
class PHPExcel extends ComponentStatic
{

    /**
     * Load file
     *
     * @param  string                    $file
     * @throws PHPExcel_Reader_Exception Unable to identify a reader for this file
     * @return PHPExcel
     */
    public static function load($file)
    {
        require_once ROOT_DIR.'/vendor/phpexcel/Classes/PHPExcel/IOFactory.php';

        return \PHPExcel_IOFactory::load($file);
    }

    /**
     * Return ref to PHPExcel
     *
     * @return \PHPExcel
     */
    public static function getPhpExcel()
    {
        require_once ROOT_DIR.'/vendor/phpexcel/Classes/PHPExcel.php';
        require_once ROOT_DIR.'/vendor/phpexcel/Classes/PHPExcel/IOFactory.php';

        return new \PHPExcel();
    }
}
