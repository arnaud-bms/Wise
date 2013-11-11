<?php
namespace Wise\Curl;

use Wise\Component\Component;

 /**
  * Class \Wise\Curl\Multi
  * 
  * This class is used to send multiple requests in same time
  *
  * @author gdievart <dievartg@gmail.com>
  */
class Multi extends Component
{

    /**
     * List curl
     * 
     * @var array 
     */
    private $listCurl = array();

    /**
     * List curl to execute
     * 
     * @var array 
     */
    private $listCurlToExecute = array();

    /**
     * List responses from the requests
     * 
     * @var array 
     */
    private $listResponse = array();

    /**
     * List of Curl informations
     * 
     * @var array
     */
    private $listInfos;
    
    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'timeout',
    );
    
    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $this->timeout = (int)$config['timeout'];
    }
    
    /**
     * Add a request to execute
     *
     * @param string $url
     * @param array $options
     * @return string $curlId
     */
    public function addRequest($url, array $options = array())
    {
        $curl = new Curl($options);
        $curl->setUrl($url);
        
        return $this->addCurl($curl);
    }

    /**
     * Add Curl to execute on multi
     *
     * @param  Curl   $curl
     * @return string Request id
     */
    public function addCurl(Curl $curl)
    {
        $curlId = uniqid('', true);
        $this->listCurl[$curlId] = $curl;
        $this->listCurlToExecute[] = $curlId;

        return $curlId;
    }
    
    /**
     * Execute multi_exec
     */
    public function request()
    {
        $multiHandle = $this->initMultiHandle();
        $this->execMultiHandle($multiHandle);
        $this->readResponseRequest($multiHandle);
    }

    /**
     * Init multi_handle
     *
     * @return resource
     */
    private function initMultiHandle()
    {
        $multiHandle = curl_multi_init();
        foreach ($this->listCurlToExecute as $curlId) {
            $curl = $this->getCurl($curlId);
            curl_multi_add_handle($multiHandle, $curl->getHandle());
        }

        return $multiHandle;
    }

    /**
     * Execute curl in multi
     *
     * @param resource $multiHandle
     */
    private function execMultiHandle($multiHandle)
    {
        $running = 0;
        $startTime = microtime(true);
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running != 0 && (microtime(true) < $startTime + $this->timeout));
    }

    /**
     * Read response to request
     *
     * @param resource $multiHandle
     */
    private function readResponseRequest($multiHandle)
    {
        while ($curlDone = curl_multi_info_read($multiHandle)) {
            if (curl_errno($curlDone['handle']) !== CURLE_OK) {
                continue;
            }
            
            foreach ($this->listCurlToExecute as $key => $curlId) {
                $curl = $this->getCurl($curlId);
                if ($curl->getHandle() === $curlDone['handle']) {
                    $this->addToCallback($curl, $curlId);
                    curl_multi_remove_handle($multiHandle, $curl->getHandle());
                    unset($this->listCurlToExecute[$key]);
                }
            }
        }
    }
    
    /**
     * Add callback for handle
     *
     * @param Curl   $curl
     * @param string $curlId
     */
    private function addToCallback(Curl $curl, $curlId)
    {
        call_user_func(
            array($this, 'callBack'),
            curl_multi_getcontent($curl->getHandle()),
            $curlId,
            $curl->getInfo()
        );
    }

    /**
     * Method called in call back
     *
     * @param string $content
     * @param string $curlId
     * @param array  $infos
     */
    private function callBack($content, $curlId, array $infos)
    {
        $this->listInfos[$curlId] = $infos;
        $this->listResponse[$curlId] = $content;
    }

    /**
     * Return response to request
     *
     * @param  string $curlId
     * @return string
     */
    public function getResponse($curlId)
    {
        if (array_key_exists($curlId, $this->listResponse)) {
            return $this->listResponse[$curlId];
        }
    }

    /**
     * Return informations about request
     *
     * @param  string $uniqId
     * @return array
     */
    public function getInfos($curlId)
    {
        return $this->listInfos[$curlId];
    }

    /**
     * Set option to Curl
     *
     * @param string $curlId
     * @param int    $option
     * @param mixed  $value
     */
    public function setOpt($curlId, $option, $value)
    {
        $curl = $this->getCurl($curlId);
        $curl->setOpt($option, $value);
    }

    /**
     * Set list options to Curl
     *
     * @param string $curlId
     * @param array  $listOptions
     */
    public function setOptArray($curlId, array $listOptions)
    {
        $curl = $this->getCurl($curlId);
        $curl->setOptArray($listOptions);
    }

    /**
     * Return ref on Curl
     *
     * @param  string        $curlId
     * @throws CurlException If uniq id does'nt exists
     * @return Curl
     */
    private function getCurl($curlId)
    {
        if (!array_key_exists($curlId, $this->listCurl)) {
            throw new CurlException('Uniq id doesn\'t exists');
        }
        
        return $this->listCurl[$curlId];
    }
}
