<?php
namespace Tlc\Format;

use \Tlc\Component\Component;

/**
 * Format data from array to csv, json, xml, serialize ...
 *
 * @author gdievart
 */
class Format extends Component 
{
    /**
     * @var array Format valid 
     */
    protected $_formatAvailable = array(
        'json', 'xml', 'csv', 'serialize'
    );
    
    /**
     * Format array
     * 
     * @param string $format
     * @param array $data 
     */
    public function formatData($format, $data)
    {
        switch($format) {
            case 'json':
                $return = $this->_arrayToJson($data);
                break;
            case 'xml':
                $return = $this->_arrayToXml($data);
                break;
            case 'csv':
                $return = $this->_arrayToCsv($data);
                break;
            case 'serialize':
                $return = $this->_arrayToSerialize($data);
                break;
            default:
                throw new FormatException("Format '$format' is not valid", 400);
        }
        
        return $return;
    }
    
    
    /**
     * Format array to XML
     * 
     * @param type $data 
     * @return string XML
     */
    protected function _arrayToXML($data, $sxe = null, $rootNode = 'xml')
    {
        if ($sxe === null) {
            $sxe = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?><' . $rootNode . ' />');
        }

        foreach($data as $key => $value) {
            $key = is_numeric($key) ? 'node' : preg_replace('/[^a-z:_-]/i', '', $key);
            if (is_array($value)) {
                $this->_arrayToXml($value, $sxe->addChild($key));
            } else {
                $sxe->addChild($key, $value);
            }
        }

        return $sxe->asXML();
    }
    
    
    /**
     * Format array to Json
     * 
     * @param array $data 
     * @return string json
     */
    protected function _arrayToJson($data)
    {
        return json_encode($data);
    }
    
    
    /**
     * Format array to serialize
     * 
     * @param type $data 
     */
    protected function _arrayToSerialize($data)
    {
        return serialize($data);
    }
}