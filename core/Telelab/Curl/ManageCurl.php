<?php
namespace Telelab\Curl;

use Telelab\Component\Component;
use Telelab\Curl\CurlException;

 /**
  * Class ManageCurl
  *
  * @author gdievart <dievartg@gmail.com>
  */
class ManageCurl extends Component
{

    /**
     * @var array List ref on curl
     */
    private $listCurl = array();

    /**
     * @var array List curl to execute
     */
    private $listCurlToExecute = array();

    /**
     * @var array List response to request
     */
    private $listResponse = array();

    /**
     * @var boolean Auto exec query add
     */
    private $autoExec = true;

    /**
     * @var int Timeout
     */
    private $timeout = 3;

    /**
     * List of Curl Info
     */
    private $listInfos;

    /**
     * Execute request
     *
     * @param string $url
     */
    public function addRequest($url)
    {
        return $this->addCurl(new Curl($url));
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
     * Add Curl to execute on multi
     *
     * @param Curl $curl
     * @return string Request id
     */
    public function addCurl(Curl $curl)
    {
        $uniqId = uniqid();
        $this->listCurl[$uniqId] = $curl;
        $this->execCurl($uniqId);
        return $uniqId;
    }


    /**
     * Init multi_handle
     *
     * @return resource
     */
    private function initMultiHandle()
    {
        $multiHandle = curl_multi_init();
        foreach ($this->listCurlToExecute as $uniqId) {
            $curl = $this->getCurl($uniqId);
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
        while ($curlDone = curl_multi_info_read($multiHandle, $nbMsg = 0)) {
            if (curl_errno($curlDone['handle']) == CURLE_OK) {
                foreach ($this->listCurlToExecute as $key => $uniqId) {
                    $curl = $this->getCurl($uniqId);
                    if ($curl->getHandle() === $curlDone['handle']) {
                        $this->addToCallback($curl, $uniqId);
                        curl_multi_remove_handle($multiHandle, $curl->getHandle());
                        unset($this->listCurlToExecute[$key]);
                    }
                }
            }
        }
    }


    /**
     * Method called in call back
     *
     * @param string $content
     * @param string $uniqId
     * @param array $infos
     */
    private function callBack($content, $uniqId, array $infos)
    {
        $this->listInfos[$uniqId] = $infos;
        $this->listResponse[$uniqId] = $content;
    }


    /**
     * Add callback for handle
     *
     * @param Curl $curl
     * @param string $uniqId
     */
    private function addToCallback(Curl $curl, $uniqId)
    {
        call_user_func(
            array($this, 'callBack'),
            curl_multi_getcontent($curl->getHandle()),
            $uniqId,
            $curl->getInfo()
        );
    }


    /**
     * Execute request Curl
     *
     * @param string $uniqId
     */
    private function execCurl($uniqId)
    {
        $curl = $this->getCurl($uniqId);
        if ($this->autoExec) {
            $this->listResponse[$uniqId] = $curl->exec();
        } else {
            $this->listCurlToExecute[] = $uniqId;
        }
    }


    /**
     * Return response to request
     *
     * @param string $uniqId
     * @return string
     */
    public function getResponse($uniqId)
    {
        if (array_key_exists($uniqId, $this->listResponse)) {
            return $this->listResponse[$uniqId];
        }
    }


    /**
     * Return informations about request
     *
     * @param string $uniqId
     * @return array
     */
    public function getInfos($uniqId)
    {
        return $this->listInfos[$uniqId];
    }


    /**
     * Set option to Curl
     *
     * @param string $uniqId
     * @param int $option
     * @param mixed $value
     */
    public function setOpt($uniqId, $option, $value)
    {
        $curl = $this->getCurl($uniqId);
        $curl->setOpt($option, $value);
    }


    /**
     * Set list options to Curl
     *
     * @param string $uniqId
     * @param array $listOptions
     */
    public function setOptArray($uniqId, array $listOptions)
    {
        $curl = $this->getCurl($uniqId);
        $curl->setOptArray($listOptions);
    }


    /**
     * Set auto exec
     *
     * @param boolean $autoExec
     */
    public function setAutoExec($autoExec)
    {
        $this->autoExec = $autoExec;
    }


    /**
     * Set timeout
     *
     * @param int $second
     */
    public function setTimeout($second)
    {
        $this->timeout = $second;
    }


    /**
     * Return ref on Curl
     *
     * @param string $uniqId
     * @throws CurlException If uniq id does'nt exists
     * @return Curl
     */
    private function getCurl($uniqId)
    {
        if (array_key_exists($uniqId, $this->listCurl)) {
            return $this->listCurl[$uniqId];
        } else {
            throw new CurlException('Uniq id doesn\'t exists');
        }
    }
}
