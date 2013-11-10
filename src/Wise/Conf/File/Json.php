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
class Json implements File
{
    /**
     * {@inherit}
     */
    public function extract($file)
    {
        return json_decode(file_get_contents($file), true);
    }
}
