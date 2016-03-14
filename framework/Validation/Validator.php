<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 02.03.2016
 * Time: 14:20
 */

namespace Framework\Validation;

/**
 * Class Validator
 * @package Framework\Validation
 */
class Validator
{
    /**
     * Validator constructor.
     * @param $object
     */
    public function __construct($object = null)
    {

    }

    public function isValid()
    {

    }

    public function getErrors()
    {

    }

    public function validation($value, $filter)
    {
        switch ($filter)
        {
            case 'string':
                if(is_string($value))
                {
                    return $value = trim(filter_var($value, FILTER_SANITIZE_STRING));
                }
                break;
            case 'boolean':
                if(filter_var($value, FILTER_VALIDATE_BOOLEAN))
                {
                    return $value;
                }
                break;
            case 'validate_email':
                if(filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    return $value = filter_var($value, FILTER_SANITIZE_EMAIL);
                }
                break;
            case 'float':
                if(filter_var($value, FILTER_VALIDATE_FLOAT))
                {
                    return $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
                }
                break;
            case 'int':
                if(filter_var($value, FILTER_VALIDATE_INT))
                {
                    return $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                }
                break;
            case 'validate_url':
                if(filter_var($value, FILTER_VALIDATE_URL))
                {
                    return $value = filter_var($value, FILTER_SANITIZE_URL);
                }
                break;
        }
        return null;
    }
}