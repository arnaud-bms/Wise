<?php
namespace Wise\Conf\File;

use Wise\Conf\File\File;

/**
 * Interface Wise\Conf\File\File
 *
 * This interface must be implement by the type file configuration
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
