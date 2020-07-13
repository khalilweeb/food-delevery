<?php 

class DB {
    private static $_instance = null;
    private $_pdo,
            $_error = false,
            $_query,
            $_results,
            $_count = 0;
    public $servername = "localhost";

            private function __construct() {
                try {
            
                    $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host').';dbname=' . Config::get('mysql/db') , Config::get('mysql/username') , Config::get('mysql/password'));        
                                 
                } catch(PDOException $e) {
                    die($e->getMessage());
                }
            }
            public static function getInstance() {
                if(!isset(self::$_instance)) {
                    self::$_instance = new DB();
                }
                return self::$_instance;
            }

            
         public function query($sql , $params = array()) {
                    $this->_error = false;
                    if($this->_query = $this->_pdo->prepare($sql)) {
                        
                        $x = 1;
                        if(count($params)) {
                            foreach($params as $param) {
                                $this->_query->bindValue($x, $param);
                                $x++;
                            }
                        }
                        if($this->_query->execute()) {
                           $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                           $this->_count = $this->_query->rowCount();
                        }else {
                            $this->_error = true;
                        }
                    }
                    return $this;
            }
              


            public function error() {

                return $this->_error;
            }
            

            public function action($action , $table , $where = array()) {

                if(count($where)  === 3) {
                    $operators = array("=" , "<=" , ">=" , "<", ">");

                    $feild      = $where[0];
                    $operator   = $where[1];
                    $value      = $where[2];


                    if(in_array( $operator ,  $operators )) {
                        echo  '`' . implode('` ,`',$keys) . '`' ;
                        $sql = "{$action} FROM {$table} WHERE {$feild} {$operator} ?";
                        if(!$this->query($sql , array($value))->error()) {
                            return $this;                                            
                        }
                    }

                }
                return false;

            }


            public function results() {
                return $this->_results;
            }
 

            public function get( $action ,$table , $where = array()) {
                return $this->action($action,$table, $where);
            }

            public function delete($table , $where = array()) {
                return $this->action('DELETE' , $table , $where);
            }

            public function insert($table, $fields = array()) {

                if(count($fields)) {
                    $keys = array_keys($fields);
                    $values = '';
                    $x = 1;

                    foreach($fields as $field) {
                        $values .= '?';

                        if($x < count($fields)) {
                            $values .= ', ';
                        }

                        $x++;

                    }

                $sql = "INSERT INTO {$table} (`" .  implode('` ,`',$keys)  . "` ) VALUES ({$values})";
                echo $sql;

                    if(!$this->query($sql,$fields )->error()) {
                        
                        return true;
                    }

                } 
                return false;

            }


            public function update($tablee , $id , $fields = array()) {
                if(count($fields)) {

                    $keys   = array_keys($fields);
                    $valuess = '';
                      
                    foreach($keys as $key) {                      
                        $valuess .= $key . '=?,';
                    }


                    $valuess = substr($valuess, 0, -1);

                $sql = "UPDATE {$tablee} SET {$valuess}  WHERE id=$id";
                
                if(!$this->query($sql,$fields )->error()) {
                        
                    return true;
                }   
                    

                }
                return false;
            }

            public function count() {
                return $this->_count;
            } 
        }

