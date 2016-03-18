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
     * @var null object
     */
    private $object = null;

    /**
     * @var array
     */
    public $error = array();

    /**
     * Validator constructor.
     * @param $object
     */
    public function __construct($object = null)
    {
        $this->object = $object;
    }

    /**
     * Check, is value correct according with parameters
     * of different classes that check this value
     */
    public function isValid()
    {
        $rules_arr = $this->object->getRules();
        $object_vars = get_object_vars($this->object);
        $this->error = null;
        foreach ($rules_arr as $key => $value)
        {
            if (array_key_exists($key, $object_vars))
            {
                $par_arr = $value;
                for($i = 0; $i<count($par_arr); $i++)
                {
                    $obj_valid = $par_arr[$i];
                    if(!($obj_valid->isValid($object_vars[$key])))
                    {
                        $this->error[$key] = $obj_valid->error();
                        break;
                    }
                }
            }
        }
        return !empty($this->error);
    }

    /**
     * Return error messages array
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->error;
    }

    /**
     * Check types of values and filter their
     *
     * @param $value
     * @param $filter
     * @return mixed|null
     */
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