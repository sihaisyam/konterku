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
session_start();
$item = new User($db);
$data = json_decode(file_get_contents("php://input"));
$item->email = $data->email;
$item->pass = $data->pass;

if($item->prosesLogin()){
    
    $data = $item->prosesLogin();
    $_SESSION['user'] = $data;
    http_response_code(200);
    echo json_encode($_SESSION['user']);
}
else{
    http_response_code(404);
    echo json_encode("Incorrect Email and Password!");
}
?>