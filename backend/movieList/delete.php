<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/MovieList.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare movie object
$movieList = new MovieList($db);
 
// get movie id
$data = json_decode(file_get_contents("php://input"));
 
// set movie id to be deleted
$movieList->id = $data->list_id;
 
// delete the movie
if($movieList->delete()){
    echo '{';
        echo '"message": "Movie list was deleted."';
    echo '}';
}
 
// if unable to delete the movie
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>