<?php
namespace Wise\Conf\File;

use Wise\Conf\File\File;

/**
 * Class \Wise\Conf\File\Json
 *
 * This class loads the configuration from a json file
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
