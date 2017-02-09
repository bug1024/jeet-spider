<?php

/**
 * A request client based on curl
 *
 * @author Jeet
 * @date 2017-02-09
 */
class Request {

    /**
     * @var array
     */
    private $__option = [];

    /**
     * GET
     *
     * @param string $url
     * @param array $data
     * return string
     */
    public function get($url, array $data = []) {
        if (!empty($data)) {
            $query = http_build_query($data);
            $url = strpos($url, '?') === false ? $url . '?' . $query : $url . $query;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * POST
     *
     * @param string $url
     * @param array $data
     * return string
     */
    public function post($url, array $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        !empty($data) && curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @TODO set option
     */
    public function setOption($option) {
        $this->__option = $option;
    }

}

