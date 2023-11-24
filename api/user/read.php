<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/user.php';
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(404);
    echo json_encode("You are not log in.");
    return false;
}

$database = new Database();
$db = $database->getConnection();
if(isset($_GET['id'])){
    $item = new User($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getSingleUser();
    if($item->fullname != null){
        // create array
        $emp_arr = array(
        "id" => $item->id,
        "fullname" => $item->fullname,
        "email" => $item->email,
        "pass" => $item->pass,
        "roles" => $item->roles,
        "created" => $item->created,      
        );
        http_response_code(200);
        echo json_encode($emp_arr);
    }
    else{
        http_response_code(404);
        echo json_encode("User not found.");
    }
}
else {
    $items = new User($db);
    $stmt = $items->getUsers();
    $itemCount = $stmt->rowCount();
    if($itemCount > 0){
        $UserArr = array();
        $UserArr["body"] = array();
        $UserArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "fullname" => $fullname,
                "email" => $email,
                "pass" => $pass,
                "roles" => $roles,
                "created" => $created,
            );
            array_push($UserArr["body"], $e);
        }
        echo json_encode($UserArr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("messstock" => "No record found."));
    }
}
?>