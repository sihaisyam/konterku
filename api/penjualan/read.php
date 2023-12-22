<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/penjualan.php';

$database = new Database();
$db = $database->getConnection();
if(isset($_GET['id'])){
    $item = new Penjualan($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getSingleSell();
    if($item->trxid != null){
        // create array
        $emp_arr = array(
        "id" => $item->id,
        "trxid" => $item->trxid,
        "nama_customer" => $item->nama_customer,
        "date_sell" => $item->date_sell,
        "nama_customer" => $item->nama_customer,
        "kasir" => $item->kasir,
        "grand_total" => $item->grand_total
        );
        http_response_code(200);
        echo json_encode($emp_arr);
    }
    else{
        http_response_code(404);
        echo json_encode("Barang not found.");
    }
}
else {
    $items = new Penjualan($db);
    $stmt = $items->getSells();
    $itemCount = $stmt->rowCount();
    if($itemCount > 0){
        $SellsArr = array();
        $SellsArr["body"] = array();
        $SellsArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "trxid" => $trxid,
                "nama_customer" => $nama_customer,
                "date_sell" => $date_sell,
                "nama_customer" => $nama_customer,
                "kasir" => $kasir,
                "grand_total" => $grand_total
            );
            array_push($SellsArr["body"], $e);
        }
        echo json_encode($SellsArr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("messdate_sell" => "No record found."));
    }
}
?>
