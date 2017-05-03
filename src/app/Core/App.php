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

    private static $instance = null;

    private $config = array();

    function __construct() {
        $this->loadConfig();
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }
    
    /**
     * 
     */
    public function register() {

        // required Base Config Providers        
        require APP_PATH . DIRECTORY_SEPARATOR . 'Core/HttpRequest.php';
        require APP_PATH . DIRECTORY_SEPARATOR . 'Core/Database.php';
        require APP_PATH . DIRECTORY_SEPARATOR . 'Http/Listener.php';

        // register Helpers
        require APP_PATH . DIRECTORY_SEPARATOR . 'Helpers/hooks.php';
        require APP_PATH . DIRECTORY_SEPARATOR . 'Helpers/response.php';
        require APP_PATH . DIRECTORY_SEPARATOR . 'Helpers/error.php';

        //register configs
        require APP_PATH . DIRECTORY_SEPARATOR . 'Config/database.php';
    }
    
    private function loadConfig() {
        
        foreach (scandir(APP_PATH . DIRECTORY_SEPARATOR . 'Config') as $file) {
            $fileParts = explode('.', $file );
            $extension = count($fileParts) - 1;
            
            if((isset($fileParts[$extension])) && $fileParts[$extension] == 'php') {
                $tempArray = include (APP_PATH . DIRECTORY_SEPARATOR . 'Config/' . $file);
                $this->config[$fileParts[0]] = $tempArray;
            }            
        }   
    }
    
    public function getConfig($config) {
        
        if (strpos($config, '.')) {
            
            $temp = &$this->config;
            
            $arrayElements = explode('.', $config);
            
            foreach ($arrayElements as $key) {
                $temp = &$temp[$key];
            }
            
            return $temp;
        }
    }
    
}

/**
 * 
 * @param App $app
 */
function start() {
    
    // instanciate new listener
    $li = new \App\Http\Listener();
    $li->setRequest($_SERVER);
    $li->process();
}
