<?php

require_once 'HttpRequest.php';

/**
 * Description listener
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
 * extends Request
 */
class Listener extends HttpRequest{

    function __construct() {
        
    }
    
    /**
     * 
     */
    public function process() {
        
        if (($this->method === self::METHOD_POST) || ($this->method === self::METHOD_GET)) {
             
            if ($this->parameters['endp'] == 'agg') {
                $this->procAggreg();
            }
            
            
        }
        
    }
    
    
    /**
     * 
     */
    private function procAggreg() {
        
        
        $db = new Database();
        
        $insertArray = array ('table' =>'itsqd_mon_messages',
            'values' => array(
                'source_id' => $this->input('id'),
                'poller' => $this->input('poller'),
                'time' => $this->input('time'),
                'type' => $this->input('type'),
                'status' => $this->input('status'),
                'service' => $this->input('service'),
                'alert_id' => $this->input('alert_id'),
                'host' => $this->input('host'),
                'ip' => $this->input('ip'),
                
                //-------------------------------------------------------
                'out_1' => $this->input('output_1'),
                'out_2' => $this->input('output_2'),
                'out_3' => $this->input('output_3'),
                
                //-------------------------------------------------------
                'thruk_url' => $this->input('url_1'),
                'sca_url' => $this->input('url_2'),
                'flg_stat' => 0)
        );
        
        $db->save($insertArray);
        
    }
    
}
