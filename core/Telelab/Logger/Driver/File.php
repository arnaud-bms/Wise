<?php
namespace Telelab\Logger\Driver;

use Telelab\Logger\Driver\Driver;

/**
 * File driver for Logger
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class File extends Driver
{
    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'file'
    );

    /**
     * @var string Path to cache folder
     */
    protected $file;

    /**
     * @var handle
     */
    protected $handle;

    /**
     * Init File driver
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->file = $config['file'];

        parent::init($config);
    }


    /**
     * Retrieve valid cache
     *
     * @param string $message
     * @param int  $level
     */
    public function log($message, $level)
    {
        if (!is_dir(dirname($this->file))) {
            mkdir(dirname($this->file), 0755, true);
        }

        file_put_contents($this->file, $message, FILE_APPEND);
    }


    /**
     * Close file
     */
    public function __destruct()
    {
        if ($this->handle !== null) {
            fclose($this->handle);
        }
    }
}
