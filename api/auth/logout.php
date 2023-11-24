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

if($item->prosesLogout()){
    http_response_code(200);
    echo json_encode("You have successfully logout");
}
else{
    http_response_code(404);
    echo json_encode("Server Error");
}
?>