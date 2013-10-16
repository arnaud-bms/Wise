<?php
namespace Telelab\Filter;

use Telelab\Component\Component;

/**
 * Filter: Check value from data
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Filter extends Component
{

    /**
     * The input value is mandatory
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isRequired($value)
    {
        return !empty($value);
    }


    /**
     * The input value is empty
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isEmpty($value)
    {
        return empty($value);
    }


    /**
     * The input value must correspond to the general form of an email address
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isEmail($value)
    {
        $atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';
        $domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';
        $regex  = '/^' . $atom . '+' .  '(\.' . $atom . '+)*' . '@' . '(' . $domain . '{1,63}\.)+'
                . $domain . '{2,10}$/i';

        return (preg_match($regex, $value) == 1);
    }


    /**
     * The input value must correspond to the general form of an email address
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isMx($value)
    {
        list($atom, $domain) = explode('@', $value);
        return checkdnsrr($domain);
    }


    /**
     * The input value can only contain alphabetic characters
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isAlpha($value)
    {
        return (preg_match('#([^a-z])#i', $value) == 1);
    }


    /**
     * The input value can only contain alphanumeric characters
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isAlphanumeric($value)
    {
        return (preg_match('#([^a-z0-9])#i', $value) == 1);
    }


    /**
     * The input value can only contain numbers
     *
     * @param string $value The value to test
     * @return boolean
     */
    public static function isNumeric($value)
    {
        return is_numeric($value);
    }


    /**
     * The input value must not contain more than the specified number of characters
     *
     * @param Mixed $value The value to test (Int or string)
     * @param int $length : The max value
     * @return boolean
     */
    public static function maxLength($value, $length)
    {
        if (is_int($value)) {
            return ($value > $length);
        } elseif (is_string($value)) {
            return (strlen($value) > $length);
        }
    }


    /**
     * The input value must not contain less than the specified number of characters
     *
     * @param Mixed $value The value to test (Int or string)
     * @param int $length : The min value
     * @return boolean
     */
    public static function minLength($value, $length)
    {
        if (is_int($value)) {
            return ($value < $length);
        } elseif (is_string($value)) {
            return (strlen($value) < $length);
        }
    }


    /**
     * The length of the input value must fall within the specified range
     *
     * @param Mixed $value The value to test (Int or string)
     * @param Array $lengths : Array of two integer (min, max)
     * @return boolean
     */
    public static function rangeLength($value, $lengths)
    {
        if (is_int($value)) {
            return ($value < $lengths[0] || $value > $lengths[1]);
        } elseif (is_string($value)) {
            return (strlen($value) < $lengths[0] || strlen($value) > $lengths[1]);
        }
    }


    /**
     * the input value must correspond to the specified regular expression
     *
     * @param string $value The value to test
     * @param string $regex : The regexp
     * @return boolean
     */
    public static function regex($value, $regex)
    {
        return (preg_match($regex, $value) == 1);
    }


    /**
     * the input value is to be passed to a named external function for validation
     *
     * @param string $value The value to test
     * @param Mixed $callback : Function to call
     * @return boolean
     */
    public static function callback($value, $callback, &$error)
    {
        return call_user_func($callback, $value, $error);
    }


    /**
     * the input value must be equal to the specified value
     *
     * @param string $value The value to test
     * @param Mixed $test : Value to test (int or string)
     * @return boolean
     */
    public static function isEqual($value, $test)
    {
        return ((string)$value === (string)$test);
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
        return ((string)$value !== (string)$test);
    }


    /**
     * The extension must be in the mExtension array or string
     *
     * @param string $value
     * @param Array $extension
     * @return boolean
     */
    public static function hasExtension ($value, $extension)
    {
        $ext = preg_replace('`.*\.([^\.]*)$`', '$1', $value);
        return in_array($ext, (array)$extension);
    }


    /**
     * Check parameter format
     *
     * @param string $value
     * @return boolean
     */
    public static function isParameter($value)
    {
        return (preg_match('/^[0-9a-zA-Z_\- ]+$/', $value));
    }


    /**
     * Check ip format
     *
     * @param string $value
     * @return boolean
     */
    public static function isIp($value)
    {
        return (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $value));
    }


    /**
     * Check uri format
     *
     * @param string $value
     * @return boolean
     */
    public static function isUri($value)
    {
        return (preg_match('/^[0-9a-zA-Z_\- \/\.\#\!\%]+$/', $value));
    }


    /**
     * Check url format
     *
     * @param string $value
     * @return boolean
     */
    public static function isUrl($value)
    {
        return (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $value));
    }


    /**
     * Check ssn format
     *
     * @param string $value
     * @return boolean
     */
    public static function isSsn($value)
    {
        return (preg_match('/^[0-9]{3}[- ][0-9]{2}[- ][0-9]{4}|[0-9]{9}$/', $value));
    }


    /**
     * Check cc format
     *
     * @param string $value
     * @return boolean
     */
    public static function isCc($value)
    {
        return (preg_match('/^([0-9]{4}[- ]){3}[0-9]{4}|[0-9]{16}$/', $value));
    }


    /**
     * Check isbn format
     *
     * @param string $value
     * @return boolean
     */
    public static function isIsbn($value)
    {
        return (preg_match('/^[0-9]{9}[[0-9]|X|x]$/', $value));
    }


    /**
     * Check date format
     *
     * @param string $value
     * @return boolean
     */
    public static function isDate($value)
    {
        return (strtotime($value) !== false);
    }


    /**
     * Check hour format
     *
     * @param string $value
     * @return boolean
     */
    public static function isHour($value)
    {
        return (strlen($value) === 4 && substr($value, 0, 2) <= 24 && substr($value, 2, 2) <= 59);
    }


    /**
     * Check time format
     *
     * @param string $value
     * @return boolean
     */
    public static function isTime($value)
    {
        return (preg_match('/^([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}$/', $value));
    }


    /**
     * Check zip format
     *
     * @param string $value
     * @return boolean
     */
    public static function isZip($value)
    {
        return (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $value));
    }


    /**
     * Check phone format
     *
     * @param string $value
     * @return boolean
     */
    public static function isPhone($value)
    {
        return (preg_match('/^(0033|0|\+?33)[0-9]([\s\-]?[0-9]{2}){4}$/', $value));
    }


    /**
     * Check mobile format
     *
     * @param string $value
     * @return boolean
     */
    public static function isMobile($value)
    {
        return (preg_match('/^(0033|0|\+?33)[67]([\s]?[0-9]{2}){4}$/', $value));
    }


    /**
     * Check hexColor format
     *
     * @param string $value
     * @return boolean
     */
    public static function isHexColor($value)
    {
        return (preg_match('/^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/', $value));
    }


    /**
     * Check user format
     *
     * @param string $value
     * @return boolean
     */
    public static function isUser($value)
    {
        return (preg_match('/^[a-zA-Z0-9_]{3,32}$/', $value));
    }


    /**
     * Check password format
     *
     * @param string $value
     * @return boolean
     */
    public static function isPassword($value)
    {
        return (preg_match('/^[0-9a-z]{4,20}$/', $value));
    }


    /**
     * Check name format
     *
     * @param string $value
     * @return boolean
     */
    public static function isName($value)
    {
        return (preg_match('/^([a-zA-Z-\'àâäéèêëîïûüœç])+(?:[\s\-][a-zA-Zàâäéèêëîïûüœç]+)*$/', $value));
    }


    /**
     * Check iban format
     *
     * @param string $value
     * @return boolean
     */
    public static function isIban($value)
    {
        return (preg_match('/[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,21}/', $value));
    }


    /**
     * Check bic format
     *
     * @param string $value
     * @return boolean
     */
    public static function isBic($value)
    {
        return (preg_match('/([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)/', $value));
    }


    /**
     * Check tva intracom format
     *
     * @param string $value
     * @return boolean
     */
    public static function isTvaIntracom($value)
    {
        return (preg_match('/^(RO\d{2,10}|GB\d{5}|(ATU|DK|FI|HU|LU|MT|CZ|SI)\d{8}|IE[A-Z\d]{8}|(DE|BG|EE|EL|LT|BE0|PT|CZ)\d{9}|CY\d{8}[A-Z]|(ES|GB)[A-Z\d]{9}|(BE0|PL|SK|CZ)\d{10}|(FR|IT|LV)\d{11}|(LT|SE)\d{12}|(NL|GB)[A-Z\d]{12})$/', $value));
    }


    /**
     * Check siret format
     *
     * @param string $value
     * @return boolean
     */
    public static function isSiret($value)
    {
        return (preg_match('/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}$/', $value));
    }
}
