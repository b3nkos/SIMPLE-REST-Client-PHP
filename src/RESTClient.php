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

namespace Botero\RESTClient;

class RESTClient implements RESTClientInterface
{
    public $status;
    public $response;
    public $error;

    private $_config = array();
    
    private $_user;
    private $_passwd;
    private $_proxy;
    private $_port;
    
    protected $_connection;
    
    public function getError() 
    {
        return $this->error;
    }

    public function getHTTPCode()
    {
        return $this->status;
    }

    public function getResponse()
    {
        return $this->response;
    }
    
    public function setProxy($host, $port, $user, $passwd)
    {
        $this->_proxy  = $host;
        $this->_port   = $port;
        $this->_user   = $user;
        $this->_passwd = $passwd; 
    }
    
    protected function setConfigurations(array $config) 
    {
        $this->_config = $config;
    }

    protected function start($url)
    {
        if (!function_exists('curl_version')) {
            throw new Exception('CURL is required');
        }

        $this->_connection = curl_init();
        curl_setopt($this->_connection, CURLOPT_URL, $url);
        curl_setopt($this->_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_connection, CURLOPT_SSL_VERIFYPEER, false);
        
        if($this->_proxy) {      
            curl_setopt($this->_connection, CURLOPT_PROXY, $this->_proxy.":".$this->_port);
            curl_setopt($this->_connection, CURLOPT_PROXYUSERPWD,$this->_user.":".$this->_passwd);
        }
    }
    
    protected function setHeader($header, $params)
    {
        $default = array(                                                                          
            'Content-Length: ' . strlen($params),            
        );

        $header = (!is_null($header)) ? array_merge($header,$default) : $default;

        curl_setopt($this->_connection, CURLOPT_HTTPHEADER, $header);  
    }

    protected function request($type, $params)
    {
        foreach ($this->_config as $key => $value) {
            curl_setopt($this->_connection, $key, $value);
        } 
        
        curl_setopt($this->_connection, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($this->_connection, CURLOPT_POSTFIELDS, $params);

        $this->response = curl_exec($this->_connection);
        $this->status   = curl_getinfo($this->_connection, CURLINFO_HTTP_CODE);
    }

    protected function process()
    {
        $array = json_decode($this->response);

        if ($array){
            $this->response = $array;
        }
    }

    protected function close()
    {
        curl_close($this->_connection);
    }

    protected function execute($url, $type, $params = null, $header = null)
    {
        $this->start($url);
        $this->setHeader($header, $params);
        $this->request($type, $params);
        $this->process();
        
        $this->error = curl_error($this->_connection);
        
        $this->close();

        return $this->status;
    }

    public function delete($url, $header = null)
    {
        return $this->execute($url, 'DELETE', null, $header);
    }

    public function get($url, $header = null)
    {
        return $this->execute($url, 'GET', null, $header);
    }

    public function post($url, $params = null, $header = null)
    {
        return $this->execute($url, 'POST', $params, $header);
    }

    public function put($url, $params = null, $header = null)
    {
        return $this->execute($url, 'PUT', $params, $header);
    }

}