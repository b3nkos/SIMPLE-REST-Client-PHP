<?php

/**
 * SIMPLE-REST-Client-PHP
 *
 * PHP version 5.3
 *
 *  @category HTML_Tools
 *  @package  HTML
 *  @author   https://github.com/botero
 *  @license  https://github.com/botero/SIMPLE-REST-Client-PHP/blob/master/licence.txt GPL V3 License
 *  @link     https://github.com/botero/SIMPLE-REST-Client-PHP
 *
 */

/**
 * this class is a simple and fast, with no dependency, scraping tool for XML
 * and HTML files, require PHP 5.3 or later and it's PSR1 standard compliant
 *
 *  @category HTML_Tools
 *  @package  HTML
 *  @author   https://github.com/botero
 *  @license  https://github.com/botero/SIMPLE-REST-Client-PHP/blob/master/licence.txt GPL V3 License
 *  @link     https://github.com/botero/SIMPLE-REST-Client-PHP
 *
 */

namespace botero\RESTClient;

interface RESTClientInterface {

    public function delete($url, $header = null);

    public function get($url, $header = null);

    public function post($url, $params = null, $header = null);

    public function put($url, $params = null, $header = null);


    public function getError();
    
    public function getResponse();

    public function getHTTPCode();
    
    
    public function setProxy($host, $port, $user, $passwd);
    
    public function setConfigurations(array $config);

}