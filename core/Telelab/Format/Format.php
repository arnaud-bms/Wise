<?php
namespace Telelab\Format;

use \Telelab\Component\Component;

/**
 * Format: data from array to csv, json, xml, serialize ...
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Format extends Component
{
    /**
     * @var array Format valid
     */
    protected $formatAvailable = array(
        'json', 'xml', 'csv', 'serialize'
    );

    /**
     * Format array
     *
     * @param string $format
     * @param array $data
     * @throws FormatException If format does'nt exists
     * @return string
     */
    public function formatData($format, $data)
    {
        switch($format) {
            case 'json':
                $return = $this->arrayToJson($data);
                break;
            case 'xml':
                $return = $this->arrayToXml($data);
                break;
            case 'csv':
                $return = $this->arrayToCsv($data);
                break;
            case 'serialize':
                $return = $this->arrayToSerialize($data);
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
    protected function arrayToXml($data, $sxe = null, $rootNode = 'xml')
    {
        if ($sxe === null) {
            if (count($data) === 1) {
                $rootNode = key($data);
                $data = $data[$rootNode];
            }
            $sxe = simplexml_load_string(
                '<?xml version="1.0" encoding="utf-8"?><'.$rootNode.' />'
            );
        }

        foreach ($data as $key => $value) {
            $key = is_numeric($key)
                ? 'node'
                : preg_replace('/[^a-z:_-]/i', '', $key);
            if (is_array($value)) {
                $this->arrayToXml($value, $sxe->addChild($key));
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
    protected function arrayToJson($data)
    {
        return json_encode($data);
    }


    /**
     * Format array to serialize
     *
     * @param type $data
     */
    protected function arrayToSerialize($data)
    {
        return serialize($data);
    }
}