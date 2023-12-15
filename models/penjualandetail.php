<?php
class PenjualanDetail{
    // Connection
    private $conn;
    // Table
    private $db_table = "penjualan_detail";
    // Columns
    public $id;
    public $kd_brg;
    public $trxid;
    public $nama_barang;
    public $harga_jual;
    public $qty;
    public $sub_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getSellDetails(){
        $sqlQuery = "SELECT id, kd_brg, trxid, nama_barang, harga_jual, qty, sub_total FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createSellDetail(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        kd_brg = :kd_brg,
        trxid = :trxid,
        nama_barang = :nama_barang,
        harga_jual = :harga_jual,
        qty = :qty,
        sub_total = :sub_total";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->kd_brg=htmlspecialchars(strip_tags($this->kd_brg));
        $this->trxid=htmlspecialchars(strip_tags($this->trxid));
        $this->nama_barang=htmlspecialchars(strip_tags($this->nama_barang));
        $this->harga_jual=htmlspecialchars(strip_tags($this->harga_jual));
        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->sub_total=htmlspecialchars(strip_tags($this->sub_total));
        // bind data
        $stmt->bindParam(":kd_brg", $this->kd_brg);
        $stmt->bindParam(":trxid", $this->trxid);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":harga_jual", $this->harga_jual);
        $stmt->bindParam(":qty", $this->qty);
        $stmt->bindParam(":sub_total", $this->sub_total);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleSell(){
        $sqlQuery = "SELECT
        id,
        kd_brg,
        trxid,
        nama_barang,
        harga_jual,
        qty,
        sub_total
        FROM
        ". $this->db_table ."
        WHERE
        trxid = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->trxid);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->kd_brg = $dataRow['kd_brg'];
        $this->trxid = $dataRow['trxid'];
        $this->nama_barang = $dataRow['nama_barang'];
        $this->harga_jual = $dataRow['harga_jual'];
        $this->qty = $dataRow['qty'];
        $this->sub_total = $dataRow['sub_total'];
    }
    
}
?>
