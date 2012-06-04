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
        if(!in_array($format, $this->_formatAvailable)) {
            throw new FormatException("Format '$format' is not valid", 400);
        }
        
        $method = '_arrayTo' . $format;
        return $this->$method($data);
    }
    
    
    /**
     * Format array to XML
     * 
     * @param type $data 
     * @return string XML
     */
    protected function _arrayToXML($data)
    {
        
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
