<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 02.03.2016
 * Time: 14:17
 */

namespace Framework\Request;

use Framework\Validation\Validator;

/**
 * Class Request
 * @package Framework\Request
 */
class Request
{
    /**
     * Get type of request method
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Check is method POST
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->getMethod()=='POST');
    }

    /**
     * Check is method GET
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->getMethod()=='GET');
    }

    /**
     * Get header parameters of HTTP request
     *
     * @param null $header
     * @return array|false|null
     */
    public function getHeaders($header = null)
    {
        $data = apache_request_headers();
        if(!empty($header))
        {
            $data = array_key_exists($header, $data) ? $data[$header] : null;
        }
        return $data;
    }

    /**
     * Return value of variable that transmitted from user
     * by POST method
     *
     * @param string $varname
     * @param string $filter
     * @return mixed
     */
    public function post($varname = '', $filter = 'STRING')
    {
        return $this->filter($_POST[$varname], $filter);
    }

    /**
     * Filter value of transmitted variable
     *
     * @param $value
     * @param string $filter
     * @return mixed|null
     */
    protected function filter($value, $filter = 'string')
    {
        $validator = new Validator();
        return $validator->validation($value, $filter);
    }
}