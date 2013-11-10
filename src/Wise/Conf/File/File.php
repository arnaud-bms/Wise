<?php
namespace Wise\Conf\File;

/**
 * Interface Wise\Conf\File\File
 *
 * This interface must be implement by the type file configuration
 *
 * @author gdievart <dievartg@gmail.com>
 */
interface File
{
    /**
     * Load a file configuration and extract it
     *
     * @param  string $file
     * @return array
     */
    public function extract($file);
}
