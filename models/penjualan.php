<?php
class Penjualan{
    // Connection
    private $conn;
    // Table
    private $db_table = "penjualan";
    // Columns
    public $id;
    public $trxid;
    public $date_sell;
    public $nama_customer;
    public $kasir;
    public $grand_total;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getSells(){
        $sqlQuery = "SELECT id, trxid, date_sell, nama_customer, kasir, grand_total FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createSell(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        trxid = :trxid,
        date_sell = :date_sell,
        nama_customer = :nama_customer,
        kasir = :kasir,
        grand_total = :grand_total";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->trxid=htmlspecialchars(strip_tags($this->trxid));
        $this->date_sell=htmlspecialchars(strip_tags($this->date_sell));
        $this->nama_customer=htmlspecialchars(strip_tags($this->nama_customer));
        $this->kasir=htmlspecialchars(strip_tags($this->kasir));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        // bind data
        $stmt->bindParam(":trxid", $this->trxid);
        $stmt->bindParam(":date_sell", $this->date_sell);
        $stmt->bindParam(":nama_customer", $this->nama_customer);
        $stmt->bindParam(":kasir", $this->kasir);
        $stmt->bindParam(":grand_total", $this->grand_total);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleSell(){
        $sqlQuery = "SELECT
        id,
        trxid,
        date_sell,
        nama_customer,
        kasir,
        grand_total
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->trxid = $dataRow['trxid'];
        $this->date_sell = $dataRow['date_sell'];
        $this->nama_customer = $dataRow['nama_customer'];
        $this->kasir = $dataRow['kasir'];
        $this->grand_total = $dataRow['grand_total'];
    }

    function deleteSells(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE trxid = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->trxid=htmlspecialchars(strip_tags($this->trxid));
        $stmt->bindParam(1, $this->trxid);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
}
?>
