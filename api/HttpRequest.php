<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description Request
 * 
 * Long Description
 *
 * @package
 * @category
 * @version 1.0.a
 * 
 * @author Andre Fonseca <andre.fg.fonseca@gmail.com>
 * @since 1.0.a
 * 
 */
class HttpRequest {
    
    
    const ERROR_NO_REQUEST_METHOD = 'HTTP_0001';
    
    
    const METHOD_POST = 1;
    
    
    const METHOD_GET = 2;
    
    
    private $post;
    
    
    private $get;
    
    
    private $server;
    
    
    private $contents;
    

    protected $method;
    /**
     *
     * @var type 
     */
    protected $requestParams;
    
    /**
     *
     * @var type 
     */
    protected $request;
    
    /**
     *
     * @var type 
     */
    protected $uri;
    
    /**
     * 
     * @param string $item
     */
    public function input($item) {
        
        if (isset($this->request[strtoupper($item)])) {
            return $this->request[strtoupper($item)];
        } else if (isset($this->parameters[$item])) {
            return $this->parameters[$item];
        } else if (isset($this->contents[$item])) {
            return $this->contents[$item];
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param type $errorCode
     * @param type $message
     */
    public function raiseError($errorCode, $message) {
        
        echo json_encode(
                array("Error"=>$errorCode,
                    'message' => $message)
        );
        
        exit(0);
    }



    //-----------------------------------------------------------------
    function getRequest() {
        return $this->request;
    }
    
    /**
     * 
     * @param type $request
     */
    function setRequest($request) {
        $this->request = $request;
        
        if ($this->isNull($this->input('REQUEST_METHOD'),'XXX') == "XXX") {
             $this->raiseError(HttpRequest::ERROR_NO_REQUEST_METHOD, 
                    'Unable to Parse Request Method from request');
             
        } else if ($this->isNull($this->input('REQUEST_METHOD'),'XXX') == "POST") {
            $this->method = self::METHOD_POST;
            $this->parameters = $_POST;
            
        } else if ($this->isNull($this->input('REQUEST_METHOD'),'XXX') == "GET") {
            $this->method = self::METHOD_GET;
            $this->parameters = $_GET;
        }
        
        return $this;
    }
    
    /**
     * 
     * @param string $string
     * @param string $replacement
     * @return string
     */
    private static function isNull($string, $replacement) {
        if ($string == null) {
            return $replacement;
        } else {
            return $string;
        }
    }
    
    function setPost($post) {
        $this->post = $post;
    }

    function setGet($get) {
        $this->get = $get;
    }

    function setServer($server) {
        $this->server = $server;
    }

    function setContents($contents) {
        $this->contents = (array) json_decode($contents);
        
    }


}
