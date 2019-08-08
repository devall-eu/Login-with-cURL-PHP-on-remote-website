<?php

/**
 * Class WS_connect
 *
 * Login and get content of webpage
 */
class WS_connect
{
    protected $username = 'YOUR_USERNAME';
    protected $password = 'YOUR_PASSWORD';
    var $URL = 'YOUR_URL';

    /**
     * WS_connect constructor
     */
    public function __construct()
    {
        $this->username;
        $this->password;
        $this->URL;
    }

    /**
     * Connect to web service
     * CURL method
     * @return object
     */
    private function connect()
    {
        $ch = curl_init();

        $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";

        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $this->URL);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 400);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        /*
        Set the cookie storing files
        Cookie files are necessary since we are logging and session data needs to be saved
        */

        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');

        $res = (object)array(
            'response' => curl_exec($ch),
            'info' => (object)curl_getinfo($ch),
            'errors' => curl_error($ch)
        );

        curl_close($ch);

        return $res;
    }

    /**
     * @return mixed|string
     */
    private function getData()
    {
        $data = $this->connect();

        if ($data->errors) return $data->errors;
        elseif ($data->response == '') return 'Response is empty!';
        else return $data->response;
    }

    /**
     * @return bool|mixed|string
     */
    public function data()
    {
        $response = $this->getData();

        if (!is_array($response)) {
            echo $response;
            return FALSE;
        } else {
            // We finally have data from WS
            return $response;
        }
    }
}