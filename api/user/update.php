<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/user.php';
$database = new Database();
$db = $database->getConnection();
$item = new User($db);
$data = json_decode(file_get_contents("php://input"));
$item->id = $data->id;

    // User values
    $item->fullname = $data->fullname;
    $item->email = $data->email;
    $item->pass = $data->pass;
    $item->roles = $data->roles;

if($item->updateUser()){
echo json_encode("User data updated.");
} else{
echo json_encode("Data could not be updated");
}
?>