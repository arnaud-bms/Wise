<?php
namespace Wise\Form;

use Wise\Form\FormRuleException;
use Wise\Filter\Filter;

/**
 * Form: Apply rule to form element
 *
 * @author Codefalse <codefalse@altern.org>
 */
class FormRule
{

    /**
     * @var Array The value of the Element analysed
     */
    protected $elementValue;

    /**
     * @var int The number of errors occured
     */
    protected $countErrors = 0;

    /**
     * @var array Contains all the Errors
     */
    protected $errors = array();

    /**
     * @var array Contains all the rules
     */
    protected $rules = array();

    /**
     * Prepare an element for the specifics rules
     *
     * @param String or Array $element   : if it's an array, separated by $delimiter
     * @param Array           $from      : Array where the Element is
     * @param String          $delimiter (default : '.') : Delimiter for array Elements
     */
    public function __construct($element, $from = null, $delimiter = '.')
    {
        $from = $from === null ? $_POST : $from;

        if (!empty($from)) {
            if (!array_key_exists($element, $from)) {
                $from[$element] = '';
            }

            if (is_array($from[$element])) {
                $this->elementValue = $from[$element];
            } elseif (is_string($element)) {
                $sSElts = explode($delimiter, $element);
                $toElement = $from;

                foreach ($sSElts as $currentElement) {
                    if (isset($toElement[$currentElement])) {
                        $toElement = $toElement[$currentElement];
                    } else {
                        $toElement = '';
                        break;
                    }
                }
                $this->elementValue = $toElement;
            } else {
                throw new FormRuleException("Element must be a String or an Array");
            }
        }
    }


    /**
     * Magic function to call functions from Filter class if it's exists !
     *
     * @param String $name : Name of the function
     * @param Array  $args : Array of parameters
     */
    public function __call($name, $args)
    {
        $ruleName = strtolower(substr($name, 3, 1)).substr($name, 4);
        if ($pos = strpos($ruleName, 'Or')) {
            $oldRuleName = $ruleName;
            $ruleName = array();
            $ruleName[] = substr($oldRuleName, 0, $pos);
            $ruleName[] = strtolower(substr($oldRuleName, $pos+2, 1)).substr($oldRuleName, $pos+3);
        }
        $ruleName = (array) $ruleName;

        if (count($args) === 2) {
            $errorMsg = $args[1];
            $params = $args[0];
        } else {
            $errorMsg = $args[0];
            $params = null;
        }

        while ($rule = array_shift($ruleName)) {
            if (Filter::$rule($this->elementValue, $params, $errorMsg)) {
                break;
            } elseif (empty($ruleName)) {
                $this->countErrors++;
                $this->errors[] = $errorMsg;
            }
        }
    }

    /**
     * Magic function of php to return the first value when the object is written
     *
     * @return mixed
     */
    public function __toString()
    {
        return (is_array($this->elementValue) ? reset($this->elementValue) : (string) $this->elementValue);
    }

    /**
     * Return the values if first parameter is set, or, a an array containing all values
     * if it's an array, or a string
     *
     * @param  String or Int $keyValue : The Value or Key in the Element
     * @param  Boolean       $byValue  : Search by Value (true) or by key (default, false)
     * @return mixed
     */
    public function getValue($keyValue = null, $byValue = false)
    {
        if (is_string($this->elementValue)) {
            return $this->elementValue;
        } else {
            if ($keyValue !== null) {
                if (!is_string($keyValue) || !is_int($keyValue)) {
                    throw new FormRuleException("KeyValue must be a String or an Integer");
                }

                if (array_key_exists($keyValue, $this->elementValue)) {
                    return $this->elementValue[$keyValue];
                }
            } elseif ($byValue !== false) {
                $keyArray = array_search($keyValue, $this->elementValue);

                return $this->elementValue[$keyArray];
            } else {
                return $this->elementValue;
            }
        }
    }


    /**
     * Indicate if the element has no errors from the rules
     *
     * @return boolean
     */
    public function isValid()
    {
        return ($this->countErrors === 0);
    }


    /**
     * Return the error given by $errno or the first
     *
     * @param  integer $errno : The number of the error
     * @return String  : The error or null
     */
    public function getError($errno = 0)
    {
        if (!is_int($errno)) {
            throw new FormRuleException("Errno must be an Int';");
        }

        if ($errno >= count($this->errors)) {
            throw new FormRuleException("Index '$errno' does not exist");
        }

        return $this->errors[$errno];
    }


    /**
     * Return an array containing all the Errors
     *
     * @return Array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }


    /**
     * Transform value to the return of the called function
     *
     * @param Mixed $method : The called function in (String) or Array ("class", "function");
     * @param Mixed $index  : Index in the array of values (default 0) Could be Int or String
     */
    public function callFunction($method, $index = 0)
    {
        if (!is_int($index) || is_string($index)) {
            throw new FormRuleException("Argument '$index' must be a String or an Integer");
        }

        if (is_callable($method)) {
            if (is_array($this->elementValue) && array_key_exists($index, $this->elementValue)) {
                $this->elementValue[$index] = call_user_func($method, $this->elementValue[$index]);
            } elseif (is_string($this->elementValue)) {
                $this->elementValue = call_user_func($method, $this->elementValue);
            }
        } else {
            throw new FormRuleException("Function $method apparently not exists");
        }
    }
}
