<?php
/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 15.02.2016
 * Time: 12:57
 */

namespace Framework\Response;

use Framework\Exception\InvalidArgumentException;

class ResponseRedirect extends \Framework\Response\Response
{
    /**
     * Redirect URL address
     *
     * @var null
     */
    protected $targetUrl;

    /**
     * ResponseRedirect constructor.
     * @param string $url
     * @param string $content
     * @param string $type
     * @param int $code
     *
     * @throws InvalidArgumentException
     */
    public function __construct($url, $content = '', $type = 'text/html', $code = 302)
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        parent::__construct($content, $type, $code);

        $this->setTargetUrl($url);
    }

    /**
     * Add location parameter to html Headers for redirection
     *
     * @param $url
     */
    public function setTargetUrl($url)
    {
        $this->targetUrl = $url;

        $this->setHeader('Location', $url);
    }
}