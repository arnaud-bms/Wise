<?php
namespace Wise\Conf\File;

use Wise\Conf\File\File;

/**
 * Class \Wise\Conf\File\Php
 *
 * This class loads the configuration from a php file
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Php implements File
{
    /**
     * {@inherit}
     */
    public function extract($file)
    {
        return include $file;
    }
}
