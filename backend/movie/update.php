<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/Movie.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare movie object
$movie = new Movie($db);
 
// get id of movie to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of movie to be edited
$movie->id = $data->id;
 
// set movie property values
$movie->name = $data->name;
 
// update the movie
if($movie->update()){
    echo '{';
        echo '"message": "movie was updated."';
    echo '}';
}
 
// if unable to update the movie, tell the user
else{
    echo '{';
        echo '"message": "Unable to update movie."';
    echo '}';
}
?>