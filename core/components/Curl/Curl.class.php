<?php
namespace Telco\Curl;

use Telco\Component\Component;

 /**
  * Class Curl
  *
  * @author gdievart <dievartg@gmail.com>
  */
class Curl extends Component
{

    /**
     * @var resource Handle on cUrl
     */
     private $_curl;

    /**
     * @var string Last error generated
     */
    private $_error = null;

    /**
     * @var int Timeout
     */
    private $_timeout = 3;


    /**
     * Construct Curl
     *
     * @param string $url
     */
    public function __construct($url = null) 
    {
        $this->_initCurl($url);
    }


    /**
     * Init basic option Curl
     *
     * @param string $url
     */
    private function _initCurl($url) 
    {
        $this->_curl = curl_init();
        $this->setUrl($url);
        $this->setOpt(CURLOPT_TIMEOUT, $this->_timeout);
        $this->setOpt(CURLOPT_RETURNTRANSFER, 1);
    }


    /**
     * Execute query
     *
     * @return mixed
     */
    public function exec() 
    {
        if(($return = curl_exec($this->_curl)) === false) {
            throw new CurlException(curl_error($this->_curl));
        }
        return $return;
    }


    /**
     * Return handle on resource curl
     *
     * @return resource
     */
    public function getHandle() 
    {
        return $this->_curl;
    }


    /**
     * Return info about request
     *
     * @return array
     */
    public function getInfo() 
    {
        return curl_getinfo($this->_curl);
    }


    /**
     * Return last error
     *
     * @return string
     */
    public function getError() 
    {
        return $this->_error;
    }


    /**
     * Set property url
     *
     * @param string $url
     */
    public function setUrl($url) 
    {
        if($url !== null) {
            $this->setOpt(CURLOPT_URL, $url);
        }
    }


    /**
     * Set option curl
     *
     * @param int $option
     * @param mixed $value
     */
    public function setOpt($option, $value) 
    {
        curl_setopt($this->_curl, $option, $value);
    }


    /**
     * Set list options curl
     *
     * @param int $listOptions
     */
    public function setOptArray(array $listOptions) 
    {
        curl_setopt_array($this->_curl, $listOptions);
    }


    /**
     * Close curl
     */
    public function __destruct() 
    {
        curl_close($this->_curl);
    }
} 