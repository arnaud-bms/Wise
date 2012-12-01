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
    protected $_callback;

    /**
     * @var string Error return when callback failed
     */
    protected $_errorCallback;

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
    public function setCallback($callback, $error)
    {
        $this->_callback = $callback;
        $this->_errorCallback = $error;
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

        if ($this->_callback !== null) {
            if (is_callable($this->_callback)) {
                if (!call_user_func($this->_callback, $this->_rules)) {
                    $this->_errors['form'] = $this->_errorCallback;
                }
            } else {
                throw new FormException("Function $this->_callback apparently not exists");
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