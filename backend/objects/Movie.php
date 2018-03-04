<?php
class Movie {
 
    // database connection and table name
    private $conn;
    private $table_name = "Movies";
 
    // object properties
    public $id;
    public $list_id;
    public $name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read movie
    public function read($inputID) {
 
       // select query
       $query = "SELECT
                   m.Name, m.MovieID, m.ListID
                FROM
                   " . $this->table_name . " m
                   WHERE m.MovieID =:MovieID";
    
 
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       //sanatize
       $goodInputID=htmlspecialchars(strip_tags($inputID));
    
       //bind
       $stmt->bindParam(":MovieID", $goodInputID);
    
 
       // execute query
       $stmt->execute();
 
       return $stmt;
    }
    
    // read movies in list
    public function readList($inputID) {
 
       // select all query
       $query = "SELECT
                   m.Name, m.MovieID, m.ListID
                FROM
                   " . $this->table_name . " m
                   WHERE m.ListID =:ListID";
    
 
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       //sanatize
       $goodInputID=htmlspecialchars(strip_tags($inputID));
    
       //bind
       $stmt->bindParam(":ListID", $goodInputID);
    
 
       // execute query
       $stmt->execute();
 
       return $stmt;
    }
    
    // create movie
    function create(){
 
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   Name=:name, ListID=:list_id";
 
       // prepare query
       $stmt = $this->conn->prepare($query);
 
       // sanitize
       $this->name=htmlspecialchars(strip_tags($this->name));
       $this->list_id=htmlspecialchars(strip_tags($this->list_id));
 
       // bind values
       $stmt->bindParam(":name", $this->name);
       $stmt->bindParam(":list_id", $this->list_id);
 
       // execute query
       if($stmt->execute()){
           return true;
       }
 
       return false;
     
   }
   
   function update(){
 
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
                   Name = :name
               WHERE
                   MovieID = :id";
 
       // prepare query statement
       $stmt = $this->conn->prepare($query);
 
       // sanitize
       $this->name=htmlspecialchars(strip_tags($this->name));
       $this->id=htmlspecialchars(strip_tags($this->id));
 
       // bind new values
       $stmt->bindParam(':name', $this->name);
       $stmt->bindParam(':id', $this->id);
 
       // execute the query
       if($stmt->execute()){
           return true;
       }
 
       return false;
   }
   
   // delete the product
   function delete(){
 
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE MovieID = ?";
 
       // prepare query
       $stmt = $this->conn->prepare($query);
 
       // sanitize
       $this->id=htmlspecialchars(strip_tags($this->id));
 
       // bind id of record to delete
       $stmt->bindParam(1, $this->id);
 
       // execute query
       if($stmt->execute()){
           return true;
       }
 
       return false;
     
   }
}
?>