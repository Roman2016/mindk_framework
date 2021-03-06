<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 12.03.2016
 * Time: 14:41
 */

namespace Framework\Validation\Filter;

/**
 * Interface ValidationFilterInterface
 * @package Framework\Validation\Filter
 */
interface ValidationFilterInterface
{
    /**
     * Check, is value correct according to conditions
     *
     * @param $value
     * @return mixed
     */
    public function isValid($value);
}