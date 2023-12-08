<?php
class User{
    // Connection
    private $conn;
    // Table
    private $db_table = "user";
    // Columns
    public $id;
    public $fullname;
    public $email;
    public $pass;
    public $roles;
    public $created;
    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }
    // GET ALL
    public function getUsers(){
        $sqlQuery = "SELECT id, fullname, email, pass, roles, created FROM ". $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO ". $this->db_table ."
        SET
        fullname = :fullname,
        email = :email,
        pass = :pass,
        roles = :roles";
        $stmt = $this->conn->prepare($sqlQuery);
            // sanitize
            $this->fullname=htmlspecialchars(strip_tags($this->fullname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->pass=htmlspecialchars(strip_tags($this->pass));
            $this->roles=htmlspecialchars(strip_tags($this->roles));
            // bind data
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":pass", $this->pass);
            $stmt->bindParam(":roles", $this->roles);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    // READ single
    public function getSingleUser(){
        $sqlQuery = "SELECT
        id,
        fullname,
        email,
        pass,
        roles,
        created        
        FROM
        ". $this->db_table ."
        WHERE
        id = ?
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->fullname = $dataRow['fullname'];
        $this->email = $dataRow['email'];
        $this->pass = $dataRow['pass'];
        $this->roles = $dataRow['roles'];
        $this->created = $dataRow['created'];
    }
    // UPDATE
    public function updateUser(){
        $sqlQuery = "UPDATE
        ". $this->db_table ."
        SET
        fullname = :fullname,
        email = :email,
        pass = :pass,
        roles = :roles
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        
        $this->fullname=htmlspecialchars(strip_tags($this->fullname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->pass=htmlspecialchars(strip_tags($this->pass));
        $this->roles=htmlspecialchars(strip_tags($this->roles));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind data
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pass", $this->pass);
        $stmt->bindParam(":roles", $this->roles);
        $stmt->bindParam(":id", $this->id);
        $stmt->fetchAll();

        try {
            $stmt->execute();
        }
        catch(PDOException $exception) {
            die($exception->getMessage());
        }
        
        if (count($stmt->fetchAll()) == 0) {
            return true;
        }
    }
    // DELETE
    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function prosesLogin(){
        $sqlQuery = "SELECT
        id,
        fullname,
        email,
        pass,
        roles,
        created         
        FROM
        ". $this->db_table ."
        WHERE
        email = :email AND
        pass = :pass
        LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pass", $this->pass);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($dataRow)){
            return $dataRow;
        }else{
            return false;
        }
    }

    public function prosesLogout(){    
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
}
?>