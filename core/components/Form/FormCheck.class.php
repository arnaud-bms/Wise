<?php
namespace Telelab\Form;

use Telelab\Component\Component;

/**
 * Form: Check form
 *
 * @author Codefalse <codefalse@altern.org>
 */
class Form extends Component
{

    /**
     * The input value is mandatory
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isRequired($value)
    {
        return !isset ($value) || empty ($value);
    }


    /**
     * The input value must correspond to the general form of an email address
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isEmail($value)
    {
        return preg_match(
			'#^([_a-z0-9-+}{]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#i',
			$value
		);
    }


    /**
     * the input value can only contain alphabetic characters
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isAlpha($value)
    {
        return preg_match('#([^a-z])#i', $value);
    }


    /**
     * the input value can only contain alphanumeric characters
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isAlphanumeric($value)
	{
        return preg_match('#([^a-z0-9])#i', $value);
    }


    /**
     * the input value can only contain numbers
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isNumeric($value)
	{
        return is_numeric($value);
    }


    /**
     * the input value must not contain more than the specified number of characters
     *
     * @param Mixed $value The value to test (Int or string)
     * @param int $iLength : The max value
     * @return boolean
     */
    public static function maxLength($value, $iLength)
	{
        if (is_int ($value))
            return ($value > $iLength) ? false : true;
        elseif (is_string ($value))
            return (strlen($value) > $iLength) ? false : true;
    }


    /**
     * the input value must not contain less than the specified number of characters
     *
     * @param Mixed $value The value to test (Int or string)
     * @param int $iLength : The min value
     * @return boolean
     */
    public static function minLength($value, $iLength)
    {
        if (is_int ($value))
            return ($value < $iLength) ? false : true;
        elseif (is_string ($value))
            return (strlen($value) < $iLength) ? false : true;
    }


    /**
     * the length of the input value must fall within the specified range
     *
     * @param Mixed $value The value to test (Int or string)
     * @param Array $aLengths : Array of two integer (min, max)
     * @return boolean
     */
    public static function rangeLength($value, $aLengths)
	{
        if (is_int($value))
            return ($value < $aLengths[0] || $value > $aLengths[1]) ? false : true;
        elseif(is_string ($value))
            return (strlen($value) < $aLengths[0] || strlen($value) > $aLengths[1]) ? false : true;
    }


    /**
     * the input value must correspond to the specified regular expression
     *
     * @param string $value The value to test
     * @param string $sRegex : The regexp
     * @return boolean
     */
    public static function regex ($value, $sRegex)
	{
        return preg_match($sRegex, $value);
    }


    /**
     * the input value is to be passed to a named external function for validation
     *
     * @param string $value The value to test
     * @param Mixed $mCallback : Function to call
     * @return boolean
     */
    public static function callback ($value, $mCallback)
	{
        if (is_array ($mCallback)) {
            if (method_exists ($mCallback[0], $mCallback[1])) {
                return call_user_func($mCallback, $value);
            }
            else
                return false;
        }
        else
            return $mCallback($value);
    }


    /**
     * the input value must be equal to the specified value
     *
     * @param string $value The value to test
     * @param Mixed $test : Value to test (int or string)
     * @return boolean
     */
    public static function isEqual ($value, $test)
	{
        return $value === $test;
    }


    /**
     * the input value must not be equal to the specified value
     *
     * @param string $value The value to test
     * @param Mixed $test : Value to test (int or string)
     * @return boolean
     */
    public static function isNotEqual ($value, $test)
	{
        return $value !== $test;
    }


    /**
     * The extension must be in the mExtension array or string
     *
     * @param string $value
     * @param Array $mExtension
     * @return boolean
     */
    public static function hasExtension ($value, $mExtension)
	{
        $sExt = preg_replace ('`.*\.([^\.]*)$`', '$1', $value);
        if (is_string ($mExtension))
            $mExtension = array ($mExtension);

        return in_array($sExt, $mExtension);
    }


    /**
     * Indicate if the value is an Url or not (
     *
     * @param unknown_type $value
     * @return unknown
     */
    public static function isUrl ($value)
	{
        return preg_match(
			'#^http[s]?://[a-z0-9./-]*[.]{1}[a-z0-9./-]*[/]{0,1}.*$#i',
			$value
		);
    }
}
