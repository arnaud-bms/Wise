<?php
namespace Telelab\Form;

use Telelab\Component\Component;

/**
 * Form: Check form
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Form extends Component
{
    /**
     * @var Array Contain all the rules
     */
    protected $_rules = array ();

    /**
     * @var String Contain the first error occured
     */
    protected $_errors = array();

    /**
     * @var mixed Callback
     */
    protected $_callback = array();

    /**
     * Add one or more rule (instances of formRule)
     *
     * @param formRule 1-xxx : One or more instance of formRule
     * @param Array $from : Array where the Element is
     * @param String $delimiter (default : '.') : Delimiter for array Elements
     * @return FormRule
     */
    public function addRule($name, $from = null, $delimiter = '.')
    {
        $this->_rules[$name] = new FormRule($name, $from, $delimiter);
        return $this->_rules[$name];
    }


    /**
     * Call functino or method after validate all rules
     *
     * @param mixed $callback Array or string
     * @param string $error
     */
    public function addCallback($callback, $error)
    {
        $callback['method'] = $callback;
        $callback['error']  = $error;
        $this->_callback[] = $callback;
    }


    /**
     * Check if the rules are valid
     *
     * @return boolean (valid or not)
     */
    public function validate()
    {
        foreach ($this->_rules as $ruleName => $rule) {
            if (!$rule->isValid()) {
                $this->_errors[$ruleName] = $rule->getError();
            }
        }

        if (empty($this->_errors) && !empty($this->_callback)) {
            foreach ($this->_callback as $callback) {
                if (is_callable($callback['method'])) {
                    if (is_array($callback['method'])) {
                        $object = $callback['method'][0];
                        $method = $callback['method'][1];
                        $return = $object->$method($this->_rules, $callback['error']);
                    } else {
                        $function = $callback['method'];
                        $return = $function($this->_rules, $callback['error']);
                    }

                    if (!$return) {
                        $this->_errors['form'] = $callback['error'];
                        break;
                    }
                } else {
                    throw new FormException("Function {$callback['method']} apparently not exists");
                }
            }
        }

        return empty($this->_errors);
    }

    /**
     * Return the first Error occured
     *
     * @return String
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}