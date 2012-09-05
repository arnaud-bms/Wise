<?php
namespace Telco\Curl;

use Telco\Component\Component;
use Telco\Router\CurlException;

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
	private $_listCurl = array();

	/**
	 * @var array List curl to execute
	 */
	private $_listCurlToExecute = array();

	/**
	 * @var array List response to request
	 */
	private $_listResponse = array();

	/**
	 * @var boolean Auto exec query add
	 */
	private $_autoExec = true;

	/**
	 * @var int Timeout
	 */
	private $_timeout = 3;

	/**
	 * List of Curl Info
	 */
	private $_listInfos;

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
		$multiHandle = $this->_initMultiHandle();
		$this->_execMultiHandle($multiHandle);
		$this->_readResponseRequest($multiHandle);
	}


	/**
	 * Add Curl to execute on multi
     * 
	 * @param Curl $curl
	 */
	public function addCurl(Curl $curl)
    {
		$uniqId = uniqid();
		$this->_listCurl[$uniqId] = $curl;
		$this->_execCurl($uniqId);
		return $uniqId;
	}


	/**
	 * Init multi_handle
     * 
	 * @return resource
	 */
	private function _initMultiHandle() 
    {
		$multiHandle = curl_multi_init();
		foreach($this->_listCurlToExecute as $uniqId) {
			$curl = $this->_getCurl($uniqId);
			curl_multi_add_handle($multiHandle, $curl->getHandle());
		}
		return $multiHandle;
	}


	/**
	 * Execute curl in multi
     * 
	 * @param resource $multiHandle
	 */
	private function _execMultiHandle($multiHandle) 
    {
		$running = 0;
		$startTime = microtime(true);
		do {
			curl_multi_exec($multiHandle, $running );
		} while ($running != 0 && (microtime(true) < $startTime + $this->_timeout));
	}


	/**
	 * Read response to request
     * 
	 * @param resource $multiHandle
	 */
	private function _readResponseRequest($multiHandle)
    {
		while($curlDone = curl_multi_info_read($multiHandle, $nbMsg = 0)) {
			if(curl_errno($curlDone['handle']) == CURLE_OK) {
				foreach($this->_listCurlToExecute as $key => $uniqId) {
					$curl = $this->_getCurl($uniqId);
					if ($curl->getHandle() === $curlDone['handle']) {
						$this->_addToCallback($curl, $uniqId);
						curl_multi_remove_handle($multiHandle, $curl->getHandle());
						unset($this->_listCurlToExecute[$key]);
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
	private function _callBack($content, $uniqId, array $infos) 
    {
		$this->_listInfos[$uniqId] = $infos;
		$this->_listResponse[$uniqId] = $content;
	}


	/**
	 * Add callback for handle
	 * 
	 * @param Curl $curl
	 * @param string $uniqId
	 */
	private function _addToCallback(Curl $curl, $uniqId) 
    {
		call_user_func(
                array($this, '_callBack'), 
                curl_multi_getcontent($curl->getHandle()), 
                $uniqId, 
                $curl->getInfo());
	}


	/**
	 * Execute request Curl
	 * 
	 * @param string $uniqId
	 */
	private function _execCurl($uniqId) 
    {
		$curl = $this->_getCurl($uniqId);
		if($this->_autoExec) {
			$this->_listResponse[$uniqId] = $curl->exec();
        } else {
			$this->_listCurlToExecute[] = $uniqId;
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
		if(array_key_exists($uniqId, $this->_listResponse)) {
			return $this->_listResponse[$uniqId];
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
		return $this->_listInfos[$uniqId];
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
		$curl = $this->_getCurl($uniqId);
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
		$curl = $this->_getCurl($uniqId);
		$curl->setOptArray($listOptions);
	}


	/**
	 * Set auto exec
	 * 
	 * @param boolean $autoExec
	 */
	public function setAutoExec($autoExec) 
   {
		$this->_autoExec = $autoExec;
	}


	/**
	 * Set timeout
     * 
	 * @param int $second
	 */
	public function setTimeout($second) 
    {
		$this->_timeout = $second;
	}


	/**
	 * Return ref on Curl
     * 
	 * @param string $uniqId
	 * @return Curl
	 */
	private function _getCurl($uniqId) 
    {
		if(array_key_exists($uniqId, $this->_listCurl)) {
			return $this->_listCurl[$uniqId];
        } else {
            throw new CurlException('Uniq id doesn\'t exists');
        }
	}
}