<?php
namespace Wise\Cache\Driver;

/**
 * Interface Wise\Cache\Driver\Cache
 * 
 * This interface must be implement by the Cache system for to be used
 *
 * @author gdievart <dievartg@gmail.com>
 */
interface Cache
{
    /**
     * Retrieve the data from the cache system
     * 
     * @param string $key The key of the data
     * @return mixed
     */
    public function get($key);

    /**
     * Set data to the cache system
     * 
     * @param string $key     The key of the data
     * @param string $content The data to cache
     * @param int    $ttl     Time to left before delete the content
     * @return mixed
     */
    public function set($key, $content, $ttl = null);
    
    /**
     * Delete data from the cache system
     * 
     * @param string $key The key of the data
     * @return boolean
     */
    public function delete($key);
    
    /**
     * Delete all datas from the cache system
     * 
     * @return boolean
     */
    public function flush();
    
    /**
     * Delete all datas from the cache system
     * 
     * @param string $key The key of the data
     * @param int    $value The value to decrement
     * @return boolean
     */
    public function decrement($key, $value = 1);
    
    /**
     * Delete all datas from the cache system
     * 
     * @param string $key The key of the data
     * @param int    $value The value to increment
     * @return boolean
     */
    public function increment($key, $value = 1);
}
