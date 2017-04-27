<?php


class Database {
    
    /**
     *
     * @var type 
     */
    private $username;
    
    
    /**
     *
     * @var type 
     */
    private $password;
    
    
    /**
     *
     * @var type 
     */
    private $hostname;
    
    /**
     *
     * @var type 
     */
    private $dbDriver;
    
    /**
     *
     * @var type 
     */
    private $config;
    
    
    /*
     * 
     */
    private $dbConnection;
    
    /**
     * 
     */
    function __construct($dbconfig = 'connection_1') {
        
        $this->open($dbconfig);
    }
    
    /**
     * 
     */
    private function open($dbconfig) {
        
        try {
            
            $this->config = $this->getConfig();
            
            $this->config = $this->config['connections'][$dbconfig];
            
            
            
            
            
            $connString = '';

            // start building connection string
            $connString = $connString . $this->config['driver'] . 
                    ':host=' . $this->config['host'] . 
                    ';dbname=' . $this->config['database'] . 
                    ';charset=UTF8';


            //print_r($connString);
            $this->dbConnection = new PDO($connString, $this->config['username'], 
                    $this->config['password']);
            
            return $this;
            
        } catch (PDOException $ex) {
            print_r($ex->getMessage());
            exit();
        }
    }
    
    /**
     * 
     * @return type
     */
    private function getConfig() {
        return include ('config/database.php');
    }
    
    /**
     * 
     * 
     * @param string $sqlStatement
     */
    public function select($sqlStatement) {
                
        $result = $this->dbConnection->query($sqlStatement)->fetchAll(PDO::FETCH_ASSOC);
        
        
        echo '<pre>';
        echo print_r($result);
        echo '</pre>';
        
        $this->close();
    }
    
    /**
     * 
     */
    public function save($parameterArray) {
        
        try {
        
            $sqlStat = 'INSERT into ' . $parameterArray['table'] . '(';
            $sqlParams = '';
            $valuesArray;
            $c = 1;

            foreach ($parameterArray['values'] as $key => $value) {
                $sqlStat .= $key . ',';
                $sqlParams .= ':' . $c . ',';
                $valuesArray[':' . $c] = $value;
                $c++;
            }

            // add the timestamp fields
            $sqlStat .= 'created_at,updated_at) '; 
            $sqlStat .= 'VALUES (' . $sqlParams;
            $sqlStat .= ':created_at,';
            $sqlStat .= ':updated_at,';

            // Add this values
            $dt = date('Y-m-d H:i:s');
            $valuesArray[':created_at'] = $dt;
            $valuesArray[':updated_at'] = $dt;

            $sqlStat = substr($sqlStat,0, strlen($sqlStat) - 1) . ')';

            $prep = $this->dbConnection->prepare($sqlStat);
            $prep->execute($valuesArray);
            
        } catch (Exception $e) {
            $this->close();
            responseJson(array('code' => '0000', 'message' => $e->getMessage()));
            
        } finally {
            $this->close();
        }
        
    }
    
    private function close() {
        $this->dbConnection = null;
    }
    
    private function addTimeFields ($sqlString) {
        
        
        
        return $sqlString;
        
    }  
}
