<img src="http://oi60.tinypic.com/2vkj2n8.jpg" /> SIMPLE REST client 
========================================

Simple implementation that supports DELETE, GET, POST, PUT and uses cURL, automatically decodes JSON and easy uncoupling. 

Helpful to:
+ Upload files to graph.facebook and do queries<br>
+ Do queries with the twitter API
+ WEB Scraping



# Table of contents
1. [Sending a GET request](#Sending-a-GET-request)
2. [Sending a form using POST](#Sending-a-form-using-POST)
3. [Sending a FILE like parameter](#Sending-a-FILE-like-parameter)
4. [SET Proxy configuration](#SET-Proxy-configuration)
5. [SEND Header](#SEND-a-custom-Header)
6. [LICENCE](https://github.com/botero/SIMPLE-REST-Client-PHP/blob/master/licence.txt)


---
<a name="Sending-a-GET-request"/>
## Sending a GET request

```php

    $url = 'https://graph.facebook.com/microsoft';
    $RESTClient = new RESTClient();

    if ( $RESTClient->get($url) == 200 )
    {
        var_dump($RESTClient->getResponse());

    } else {

        echo 'error: HTTP status '.$RESTClient->getStatus();
    }

```
<a name="Sending-a-form-using-POST"/>
## Sending a form using POST

```php

    $url    = 'https://graph.facebook.com/<username>/feed';
    $RESTClient = new RESTClient();

    $params =  array( 
        'message' =>'Facebook for Websites is super-cool',
        'access_toke' => '....',
    );

    if ( $RESTClient->post($url, $params) == 200 )
    {
        var_dump($RESTClient->getResponse());

    } else {

        echo 'error: HTTP status '.$RESTClient->getStatus();
    }

```
<a name="Sending-a-FILE-like-parameter"/>
## Sending a FILE like parameter

```php

    $url    = 'https://example.com';
    $RESTClient = new RESTClient();

    $params = array( 'file' => "@".realpath($FileRoute), );

    if ( $RESTClient->post($url, $params) == 200 )
    ...

```
<a name="Sending-a-GET-request"/>
## SET cURL configuration

```php

    $url    = 'https://example.com';
    $RESTClient = new RESTClient();

    $RESTClient->setConfigurations(
        array( 
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 15,
            )
        );    
    ....

```
<a name="SET-Proxy-configuration"/>
## SET proxy configuration

```php

    $url    = 'https://example.com';
    $RESTClient = new RESTClient();

    $RESTClient->setProxy('host','8080','user','pass');
    .....

```
<a name="SEND-a-custom-Header"/>
## SEND a custom Header

```php

    $url = 'https://graph.facebook.com/microsoft';
    $RESTClient = new RESTClient();
    
    $header = array(
        "X-Requested-With: XMLHttpRequest", 
        "Content-Type: application/json;    
    );
    
    $RESTClient->get($url,$header)
    .....

```