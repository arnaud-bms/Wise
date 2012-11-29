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
     * Contain all the rules
     *
     * @var Array
     */
    protected $_rules = array ();

    /**
     * Contain the first error occured
     *
     * @var String
     */
    protected $_errors = array();

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