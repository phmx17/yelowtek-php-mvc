<?php
  /*
   * PDO Database class
   * Connect to database
   * create prepared statements
   * bind values
   * return rows and results
   */
  class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // db handler
    private $stmt;  // statement
    private $error; 

    public function __construct() {
      // set DSN
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      
      // setting default options; one done later will fetch objects instead of ass arrs
      $options = array(
        PDO::ATTR_PERSISTENT => true, // incr perf by checking for persistent db connection
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // there are 3: silent, warning, exceptions = best / elegant
      );

      // create pdo instance with try catch exception
      try {
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch(PDOException $e) {
        $this->error = $e->getMessage();  // $error from above;
        echo $this->error; 
      }
    }

    // prepare statement with query string
    public function query($sql) {
      $this->stmt = $this->dbh->prepare($sql);  // built in
    }
    
    // bind value: https://www.php.net/manual/en/pdostatement.bindvalue.php
    // they are parameter, value and data type
    // PDO::PARAM_NULL (int) Represents the SQL NULL data type.
    
    public function bind($params, $value, $type = null){
      // if no type is passed in (null) then run switch
      if(is_null($type)) {
        switch(true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
          break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
          break;
          case is_null($value):
            $type = PDO::PARAM_NULL;f
          break;
          default:
            $type = PDO::PARAM_STR;
        }
      }
      // bind the values
      $this->stmt->bindValue($param, $value, $type);  // built in
    }
      // execute the prepared statement
      public function execute() {
        return $this->stmt->execute();
      }

      // fetch result set as array of objects
      public function resultSet() {
        $this->execute(); // from above
        return $this->stmt->fetchAll(PDO::FETCH_OBJ); // option to return as objects and not ass arrs
      }

      // fetch single row
      public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
      }
  
      // get row count
      public function rowCount() {
        return $this->stmt->rowCount();
      }
  }