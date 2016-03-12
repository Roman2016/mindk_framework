<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 02.03.2016
 * Time: 14:17
 */

namespace Framework\Request;

/**
 * Class Request
 * @package Framework\Request
 */
class Request
{
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return ($this->getMethod()=='POST');
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return ($this->getMethod()=='GET');
    }

    /**
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
     * @param string $varname
     * @param string $filter
     * @return mixed
     */
    public function post($varname = '', $filter = 'STRING')
    {
        return $this->filter($_POST[$varname], $filter);
    }

    /**
     * @param $value
     * @param string $filter
     */
    protected function filter($value, $filter = 'STRING')
    {
        // @TODO: ...
    }
}