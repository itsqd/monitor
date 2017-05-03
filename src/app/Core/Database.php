<?php

namespace App\Core;

use PDO;
use Exception;

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
    /*
     * 
     */
    private $dbConnection;
    
    /**
     * 
     * @param array $config
     */
    function __construct($dbconfig) {
        
        $this->open($dbconfig);
    }
    
    function __destruct() {
        $this->close();
    }
    
    /**
     * 
     */
    private function open($dbconfig) {
        
        try {
            
            $connString = '';

            // start building connection string
            $connString = $connString . $dbconfig['driver'] . 
                    ':host=' . $dbconfig['host'] . 
                    ';dbname=' . $dbconfig['database'] . 
                    ';charset=UTF8';

            $this->dbConnection = new PDO($connString, $dbconfig['username'], 
                    $dbconfig['password']);
            
            return $this;
            
        } catch (Exception $ex) {
            jsonErrorReturn('Datatabse Connection',
                    $ex->getMessage(), 
                    (__FUNCTION__), 
                    (__CLASS__), 
                    $ex->getTrace());
            exit();
        }
    }
    
    
    /**
     * Execute a custom query against the database and
     * return an associative array
     * 
     * The result should be an array with 3 elements
     * failed: true or false
     * res: For the actual query result
     * error: in case of an error occurs, the message will
     * be in this element
     * 
     * @param string $sqlStatement
     * @return array
     * @throws Exception
     */
    public function select($sqlStatement) {
        
        $result['failed'] = false;
        
        try {
            
            $res = $this->dbConnection->query($sqlStatement);
            
            // If is not a class then the query is giving an error
            // throw an exception
            if (is_bool($res)) {
                throw new Exception('An error as ocurred while executing ' . 
                        'the SQL Statement: ' . $sqlStatement);
            }
            
            $result['res'] = $res->fetchAll(PDO::FETCH_ASSOC);
            
            
        
        } catch (Exception $exc) {
            
            $result['failed'] = true;
            $result['res'] = null;
            $result['error'] = $exc->getMessage(); 
            
        } finally {
            return $result;
        }
          

        
        
        
    }
    
    /**
     * Parse the parameters for insert into Database
     * creating a SQL statement with the parameters
     * 
     * @param array $parameterArray
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
            
            return;
            
        } catch (Exception $e) {
            $this->close();
            responseJson(array('code' => '0001', 'message' => $e->getMessage()));
            
        } finally {
            $this->close();
        }
        
    }
    
    /**
     * Close database connection
     * 
     */
    private function close() {
        return $this->dbConnection = null;
    }
}
