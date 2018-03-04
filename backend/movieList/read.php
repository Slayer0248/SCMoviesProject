<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/MovieList.php';
 
// initialize database
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$movieList = new MovieList($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

 

// instantiate database and movie object
$database = new Database();
$db = $database->getConnection();
 

// query movies
$stmt = $movieList->read($data->list_id);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // movies array
    $movies_arr=array();
    $movies_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $movie_item=array(
            "ListID" => $id,
            "ListName" => $name
        );
 
        array_push($movies_arr["records"], $movie_item);
    }
 
    echo json_encode($movies_arr);
}
 
else{
    echo json_encode(
        array("message" => "No movies found.")
    );
}
?>