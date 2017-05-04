<?php

namespace App\Http;

use App\Core\HttpRequest;
use App\Core\Database;

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
class Listener extends HttpRequest {
    
    private $dbConnection;
    
    private $appInstance;
    /**
     * 
     * @param \App\Core\App $app
     */
    function __construct() {
        
        $this->appInstance = \App\Core\App::getInstance();
        
        $this->setContents(file_get_contents('php://input'));
        $this->setGet($_GET);
        $this->setPost($_POST);
        $this->setServer($_SERVER);
        
        $this->dbConnection = $this->appInstance->getConfig('database.poll_1');
        
    }
    
    /**
     * 
     */
    public function process() {
        
        if (($this->method === self::METHOD_POST) || 
                ($this->method === self::METHOD_GET)) {
            
            if ($this->input('endp') == 'agg') {
                $this->procAggreg();
            } elseif ($this->input('endp') == 'new') {
                $this->newAlerts();
            } elseif ($this->input('endp') == 'ref') {
                $this->refreshAlerts();
            } elseif ($this->input('endp') == 'upd') {
                $this->updateAlerts();
            } elseif ($this->input('endp') == 'info') {
                $this->endPointInfo ();
            }
        }   
    }
    
    /**
     * 
     */
    private function procAggreg() {
        
        $db = new Database($this->dbConnection);
        
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
                'actions' => $this->input('actions'),
                'info' => $this->input('info'),
                'prio' => $this->input('prio'),
                'graph' => $this->input('graph'),
                'flg_stat' => 0)
        );
        
        $db->save($insertArray);
        
        responseJson(array('code' => '0000', 'message' => 'OK'));
        
    }
    
    /**
     * 
     */
    private function newAlerts() {
        
       
        $db = new Database($this->dbConnection);
        
        header('Content-Type: application/json');
        
        if ($this->input('act') == 'init') {
        
            $query = "select message_id, 
                    source_id,
                    poller,
                    time,
                    type,
                    status,
                    service,
                    alert_id,
                    host,
                    ip,
                    uid,
                    gid,
                    flg_stat
                    from itsqd_mon_messages where " . 
                    "(flg_stat = 0 or flg_stat is null) " . 
                    " order by message_id desc limit 10";

            $result = $db->select($query);

            if($result['failed']) {
                http_response_code(204);
                $message = json_encode (
                        array(
                            'failed' => 1,
                            'error_message' => $result['error']
                        ));
            } else {
                http_response_code(200);
                $message = json_encode (
                        array(
                            'failed' => 0,
                            'row_count' => count($result['res']),
                            'rows' => $result['res']));    
            }

            echo $message;
            exit(0);
        }
    }
    
    /**
     * 
     */
    private function updateAlerts() {
        responseJson(array('message' => 'Update Alert Endpoint reached!!!'));
    }
    
    /**
     * 
     */
    private function refreshAlerts() {
        responseJson(array('message' => 'Refresh Alerts Endpoint reached!!!'));
    }
    
    /**
     * Return info from EndPoint Services
     */
    private function endPointInfo () 
            {
        
        $array = array(
            "endpoints" => array(
                "endpoint" => array(
                    "endp" => "new",
                    "act" => "init",
                    "url" => "api.php?endp=new&act=init",
                    "response_fields" => array(
                        "message_id",
                        "source_id",
                        "poller",
                        "time",
                        "type",
                        "status",
                        "service",
                        "alert_id",
                        "host",
                        "ip",
                        "uid",
                        "gid",
                        "flg_stat"
                    )
                )
            )
        );
        
        
        header('Content-Type: application/json');
        echo json_encode($array);
    }
}
