<?php
namespace Wise\Curl;

use Wise\Component\Component;

 /**
  * Class \Wise\Curl\Curl
  * 
  * This class in used to send requests with cURL
  *
  * @author gdievart <dievartg@gmail.com>
  */
class Curl extends Component
{

    /**
     * Handle on cUrl
     * 
     * @var resource
     */
     private $curl;

    /**
     * {@inherit}
     */
    protected function init($config)
    {
        if (!extension_loaded('curl')) {
            throw new Exception('The extension cUrl is not installed', 0);
        }
        $this->curl = curl_init();
        
        if (!empty($config['options']) && is_array($config['options'])) {
            foreach ($config['options'] as $option => $value) {
                $constant = 'CURLOPT_'.  \Wise\String\String::upper($option);
                if (!defined($constant)) {
                    throw new Exception('The constant "'.$constant.'" does not exist');
                }
                $this->setOpt(constant($constant), $value);
            }
        }
    }

    /**
     * Execute the query
     *
     * @throws CurlException Return curlerror
     * @return mixed
     */
    public function exec()
    {
        if (false === $response = curl_exec($this->curl)) {
            throw new Exception(curl_error($this->curl));
        }

        return $response;
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
     * Return the infos about the last request
     *
     * @return array
     */
    public function getInfo()
    {
        return curl_getinfo($this->curl);
    }

    /**
     * Set the property url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->setOpt(CURLOPT_URL, $url);
    }

    /**
     * Set option
     *
     * @param int   $option
     * @param mixed $value
     */
    public function setOpt($option, $value)
    {
        curl_setopt($this->curl, $option, $value);
    }

    /**
     * Set list options
     *
     * @param array $listOptions
     */
    public function setOptArray(array $options)
    {
        curl_setopt_array($this->curl, $options);
    }

    /**
     * Close cURL
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }
}
