<?php
namespace Telelab\Cache\Driver;

use Telelab\Cache\Driver\Driver;

/**
 * File: File driver of the cache system
 *
 * @author gdievart <dievartg@gmail.com>
 */
class File extends Driver
{
    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'path',
        'ttl'
    );

    /**
     * @var string Path to cache folder
     */
    protected $path;

    /**
     * @var int ttl
     */
    protected $ttl;

    /**
     * Init File driver
     *
     * @param array $config
     */
    public function init($config)
    {
        $this->path = $config['path'];
        $this->ttl  = $config['ttl'];
    }


    /**
     * Retrieve valid cache
     *
     * @param type $uniqId
     * @return string Content, if the request's cache exists
     */
    public function getCache($uniqId)
    {
        $file = $this->path.'/'.$uniqId.'.cache';
        if (file_exists($file)) {
            if (filemtime($file) > (time() - $this->ttl)) {
                return file_get_contents($file);
            } else {
                unlink($file);
            }
        }
    }


    /**
     * Set cache
     *
     * @param type $uniqId
     * @param type $content
     */
    public function setCache($uniqId, $content, $ttl = null)
    {
        $file = $this->path.'/'.$uniqId.'.cache';
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0775, true);
        }
        file_put_contents($file, $content);
    }
}
