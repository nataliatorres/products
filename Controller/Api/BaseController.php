<?php

class BaseController {

    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', ['HTTP/1.1 404 Not Found']);
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {
        $query_string = '';

        if (!empty($_SERVER['QUERY_STRING'])) {

            //Turning the query parameter into a variable.
            parse_str($_SERVER['QUERY_STRING'], $query);
            $query_string = $query;
        }

        return $query_string;
    }

    /**
     * Send API output.
     *
     * @param mixed $data
     * @param array $httpHeaders
     */
    protected function sendOutput($data, $httpHeaders = [])
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }
}