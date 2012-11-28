<?php
namespace Telelab\Cache\Driver;

use Telelab\Cache\Driver\Driver;

/**
 * Driver Cache with file system
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class File extends Driver
{
    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'path',
        'ttl'
    );

    /**
     * @var string Path to cache folder
     */
    protected $_path;

    /**
     * @var int ttl
     */
    protected $_ttl;

    /**
     * Init File driver
     *
     * @param array $config
     */
    public function _init($config)
    {
        $this->_path = $config['path'];
        $this->_ttl  = $config['ttl'];
    }


    /**
     * Retrieve valid cache
     *
     * @param type $uniqId
     */
    public function getCache($uniqId)
    {
        $file = $this->_path.'/'.$uniqId.'.cache';
        if (file_exists($file)) {
            if (filemtime($file) > (time() - $this->_ttl)) {
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
    public function setCache($uniqId, $content)
    {
        $file = $this->_path.'/'.$uniqId.'.cache';
        file_put_contents($file, $content);
    }
}
