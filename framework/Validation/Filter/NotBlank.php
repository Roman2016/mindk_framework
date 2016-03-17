<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 08.03.2016
 * Time: 22:33
 */

namespace Framework\Validation\Filter;

/**
 * Class NotBlank
 * @package Framework\Validation\Filter
 */
class NotBlank implements ValidationFilterInterface
{
    /**
     * Check, is value correct according with parameters
     *
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        return !empty($value);
    }

    /**
     * Return error message
     *
     * @return string
     */
    public function error()
    {
        return "Field is empty";
    }
}