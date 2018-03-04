<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/Movie.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare movie object
$movie = new Movie($db);
 
// get movie id
$data = json_decode(file_get_contents("php://input"));
 
// set movie id to be deleted
$movie->id = $data->id;
 
// delete the movie
if($movie->delete()){
    echo '{';
        echo '"message": "Movie was deleted."';
    echo '}';
}
 
// if unable to delete the movie
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>