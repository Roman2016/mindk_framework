<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 15.02.2016
 * Time: 12:59
 */

namespace Framework\Response;

class JsonResponse extends \Framework\Response\Response
{
    /**
     * JsonResponse constructor.
     * @param array $content
     * @param string $type
     * @param int $code
     */
    public function __construct($content, $type = 'text/html', $code = 200)
    {
        parent::__construct($content, $type, $code);
    }

    /**
     * Функция для отправки (отображения) параметров Body
     */
    public function sendBody()
    {
        echo json_encode($this->content);
    }
}