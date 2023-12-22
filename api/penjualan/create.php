<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/penjualan.php';
include_once '../../models/penjualandetail.php';
$database = new Database();
$db = $database->getConnection();
$item = new Penjualan($db);
$data = json_decode(file_get_contents("php://input"));
$item->trxid = $data->trxid;
$item->date_sell = $data->date_sell;
$item->nama_customer = $data->nama_customer;
$item->kasir = $data->kasir;
$item->grand_total = $data->grand_total;
$db->beginTransaction();
if($item->createSell()){
    $details = new PenjualanDetail($db);
    foreach($data->details as $barang){ 
        $details->kd_brg = $barang->kd_brg;
        $details->trxid = $data->trxid;
        $details->nama_barang = $barang->nama_barang;
        $details->harga_jual = $barang->harga_jual;
        $details->qty = $barang->qty;
        $details->sub_total = $barang->sub_total;
        if(!$details->createSellDetail()){
            $db->rollBack();
            echo json_encode('Produk '.$barang->nama_barang.' saldo tidak mencukupi.');
            return false;
        }
    }
    $db->commit();
    echo json_encode('Penjualan created successfully.');
} else{
    $db->rollBack();
    echo 'Penjualan could not be created.';
}
?>
