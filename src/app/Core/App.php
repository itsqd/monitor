<?php

namespace App\Core;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description App
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
class App {
    
    public static function getInstance()
    {
        
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }
    
    function __construct() {
        
    }
    
    
    function register() {
        
        $this->getInstance();
        
        // required Base Config Providers        
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Core/HttpRequest.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Core/Database.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Http/Listener.php';
        
        // register Helpers
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/hooks.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/response.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/error.php';
        
        //register configs
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Config/database.php';
        
    }
    
    public function start() {
        
        // instanciate new listener
        $li = new \App\Http\Listener();
        $li->setRequest($_SERVER);
        $li->process();
    }
}
