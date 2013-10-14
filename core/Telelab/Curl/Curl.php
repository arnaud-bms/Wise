<?php
namespace Telelab\Curl;

use Telelab\Component\Component;

 /**
  * Curl
  *
  * @author gdievart <g.dievart@telemaque.fr>
  */
class Curl extends Component
{

    /**
     * @var resource Handle on cUrl
     */
     private $curl;

    /**
     * @var string Last error generated
     */
    private $error = null;

    /**
     * @var int Timeout
     */
    private $timeout = 3;


    /**
     * Construct Curl
     *
     * @param string $url
     */
    protected function init($url)
    {
        $this->curl = curl_init();
        $this->setUrl($url);
        $this->setOpt(CURLOPT_TIMEOUT, $this->timeout);
        $this->setOpt(CURLOPT_RETURNTRANSFER, 1);
    }


    /**
     * Execute query
     *
     * @throws CurlException Return curlerror
     * @return mixed
     */
    public function exec()
    {
        if (($return = curl_exec($this->curl)) === false) {
            throw new CurlException(curlerror($this->curl));
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
        return $this->curl;
    }


    /**
     * Return info about request
     *
     * @return array
     */
    public function getInfo()
    {
        return curl_getinfo($this->curl);
    }


    /**
     * Return last error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * Set property url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        if ($url !== null) {
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
        curl_setopt($this->curl, $option, $value);
    }


    /**
     * Set list options curl
     *
     * @param int $listOptions
     */
    public function setOptArray(array $listOptions)
    {
        curl_setopt_array($this->curl, $listOptions);
    }


    /**
     * Close curl
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }
}
