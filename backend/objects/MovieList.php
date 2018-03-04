<?php
class MovieList {
 
    // database connection and table name
    private $conn;
    private $table_name = "MovieLists";
 
    // object properties
    public $id;
    public $name;
    public $movies;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
        // read one list
    public function read($inputID) {
 
       // select query
       $query = "SELECT
                   m.ListName, m.ListID
                FROM
                   " . $this->table_name . " m
                 WHERE 
                    m.ListID=:ListID";
    
 
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
    
        // read all lists
    public function readAll() {
 
       // select all query
       $query = "SELECT
                   m.ListName, m.ListID
                FROM
                   " . $this->table_name . " m";
    
 
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
 
       // execute query
       $stmt->execute();
 
       return $stmt;
    }
    
    
    // create movieList
    function create(){
 
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . " (ListName)
               VALUES (:name)";
 
       // prepare query
       $stmt = $this->conn->prepare($query);
 
       // sanitize
       $this->name=htmlspecialchars(strip_tags($this->name));
 
       // bind values
       $stmt->bindParam(":name", $this->name);
 
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
                   ListName = :name
               WHERE
                   ListID = :id";
 
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
   
   // delete the list
   function delete(){
 
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE ListID = ?";
 
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