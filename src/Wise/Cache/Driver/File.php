<?php
namespace Wise\Cache\Driver;

/**
 * File: File driver of the cache system
 * 
 * This cache system stores the data on the file system
 * It is more slow than Memcache but the data is persistent
 *
 * @author gdievart <dievartg@gmail.com>
 */
class File extends \Wise\Component\Component implements \Wise\Cache\Driver\Cache
{
    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'path',
        'ttl'
    );

    /**
     * Path to directory where the datas are write
     * 
     * @var string Path to cache folder
     */
    protected $path;

    /**
     * Time to left before the datas are deleted
     * 
     * @var int
     */
    protected $ttl;

    /**
     * {@inherit}
     */
    public function init($config)
    {
        $this->path = $config['path'];
        $this->ttl  = $config['ttl'];
    }

    /**
     * {@inherit}
     */
    public function get($key)
    {
        $file = $this->path.'/'.$key.'.cache';
        if (file_exists($file)) {
            if (filemtime($file) > (time() - $this->ttl)) {
                return file_get_contents($file);
            } else {
                unlink($file);
            }
        }
        return false;
    }

    /**
     * {@inherit}
     */
    public function set($key, $content, $ttl = null)
    {
        $file = $this->path.'/'.$key.'.cache';
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0775, true);
        }
        file_put_contents($file, $content);
    }
    
    /**
     * {@inherit}
     */
    public function delete($key)
    {
        $file = $this->path.'/'.$key.'.cache';
        @unlink($file);
    }
    
    /**
     * {@inherit}
     */
    public function flush()
    {
        array_map('unlink', glob($this->path.'/*.cache'));
    }
    
    /**
     * {@inherit}
     */
    public function decrement($key, $value = 1)
    {
        if ($content = $this->get($key)) {
            $content-= $value;
            $this->set($key, $content);
            
            return $content;
        }
        return false;
    }
    
    /**
     * {@inherit}
     */
    public function increment($key, $value = 1)
    {
        return $this->decrement($key, -$value);
    }
}
