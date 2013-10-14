<?php
namespace Telelab\Type;

use Telelab\Component\Component;

/**
 * FormHelper: Helper that generate form components (html) and handle it
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class ArrayType extends Component
{

    /**
     * Merge array recursive override (php native array_merge_recursive merge creating array)
     *
     * @param array $firstArray
     * @param array $secondArray
     * @return array
     */
    public static function mergeRecursive($firstArray, $secondArray)
    {
        if (!is_array($firstArray) || !is_array($secondArray)) {
            return $secondArray;
        }

        foreach ($secondArray as $sKey2 => $sValue2) {
            $firstArray[$sKey2] = self::mergeRecursive(@$firstArray[$sKey2], $sValue2);
        }
        return $firstArray;
    }
}
