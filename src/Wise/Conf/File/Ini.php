<?php
namespace Wise\Conf\File;

use Wise\Conf\File\File;

/**
 * Class \Wise\Conf\File\Ini
 *
 * This class loads the configuration from an ini file
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Ini implements File
{
    /**
     * {@inherit}
     */
    public function extract($file)
    {
        return parse_ini_file($file, true);
    }
}
