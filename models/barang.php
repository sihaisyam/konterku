<?php
class Barang{
    // Connection
    private $conn;
    // Table
    private $db_table = "barang";
    // Columns
    public $id;
    public $kd_brg;
    public $nama_brg;
    public $harga_brg;
    public $stock;
    public $jenis_brg;
    public $harga_beli;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getBarangs(){
        $sqlQuery = "SELECT id, kd_brg, nama_brg, harga_brg, stock, jenis_brg, harga_beli FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createBarang(){
        $sqlQuery = "INSERT INTO". $this->db_table ."
        SET
        kd_brg = :kd_brg,
        nama_brg = :nama_brg,
        harga_brg = :harga_brg,
        stock = :stock,
        jenis_brg = :jenis_brg,
        harga_beli = :harga_beli";
        $stmt = $this->conn->prepare($sqlQuery);
        // sanitize
        $this->kd_brg=htmlspecialchars(strip_tags($this->kd_brg));
        $this->nama_brg=htmlspecialchars(strip_tags($this->nama_brg));
        $this->harga_brg=htmlspecialchars(strip_tags($this->harga_brg));
        $this->stock=htmlspecialchars(strip_tags($this->stock));
        $this->jenis_brg=htmlspecialchars(strip_tags($this->jenis_brg));
        $this->harga_beli=htmlspecialchars(strip_tags($this->harga_beli));
        // bind data
        $stmt->bindParam(":kd_brg", $this->kd_brg);
        $stmt->bindParam(":nama_brg", $this->nama_brg);
        $stmt->bindParam(":harga_brg", $this->harga_brg);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":jenis_brg", $this->jenis_brg);
        $stmt->bindParam(":harga_beli", $this->harga_beli);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleBarang(){
    $sqlQuery = "SELECT
    id,
    kd_brg,
    nama_brg,
    harga_brg,
    stock,
    jenis_brg,
    harga_beli
    FROM
    ". $this->db_table ."
    WHERE
    id = ?
    LIMIT 0,1";
    $stmt = $this->conn->prepare($sqlQuery);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->name = $dataRow['name'];
    $this->email = $dataRow['email'];
    $this->age = $dataRow['age'];
    $this->designation = $dataRow['designation'];
    $this->created = $dataRow['created'];
    }
    // UPDATE
    public function updateEmployee(){
    $sqlQuery = "UPDATE
    ". $this->db_table ."
    SET
    name = :name,
    email = :email,
    age = :age,
    designation = :designation,
    created = :created
    WHERE
    id = :id";
    $stmt = $this->conn->prepare($sqlQuery);
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->age=htmlspecialchars(strip_tags($this->age));
    $this->designation=htmlspecialchars(strip_tags($this->designation));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->id=htmlspecialchars(strip_tags($this->id));
    // bind data
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":age", $this->age);
    $stmt->bindParam(":designation", $this->designation);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":id", $this->id);
    if($stmt->execute()){
    return true;
    }
    return false;
    }
    // DELETE
    function deleteEmployee(){
    $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
    $stmt = $this->conn->prepare($sqlQuery);
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);
    if($stmt->execute()){
    return true;
    }
    return false;
    }
}
?>
