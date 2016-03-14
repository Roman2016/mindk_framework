<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 08.03.2016
 * Time: 22:32
 */

namespace Framework\Validation\Filter;

/**
 * Class Length
 * @package Framework\Validation\Filter
 */
class Length implements ValidationFilterInterface
{
    /**
     * @var
     */
    protected $min;

    /**
     * @var
     */
    protected $max;

    /**
     *
     *
     * @param $min
     * @param $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     *
     *
     * @param $value
     * @return bool
     */
    public function isValid($value)
    {
        return (strlen($value)>=$this->min) && (strlen($value)<=$this->max);
    }
}