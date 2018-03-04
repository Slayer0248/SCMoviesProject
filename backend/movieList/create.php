<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate movie object
include_once '../objects/MovieList.php';
 
$database = new Database();
$db = $database->getConnection();
 
$movieList = new MovieList($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set movie property values
//$movieList->list_id = $_POST["id"];
$movieList->name = $data->name;
 
// create the movie
if($movieList->create()){
    echo '{';
        echo '"message": "movie list was created."';
    echo '}';
}
 
// if unable to create the movie, tell the user
else{
    echo '{';
        echo '"message": "Unable to create movie list."';
    echo '}';
}
?>