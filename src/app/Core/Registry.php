<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description Registry
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
class Registry {
    
    public static function registerApp() {
        
        // required Base Config Providers        
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Core/HttpRequest.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Core/Database.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Http/Listener.php';
        
        // register Helpers
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/hooks.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/response.php';
        require APP_PATH  . DIRECTORY_SEPARATOR . 'Helpers/error.php';
                
    }
    
}
