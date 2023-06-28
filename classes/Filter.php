<?php

class Filter {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    //Filtering Table
    public function getTableBy($table_name, $column_name, $filter_value, $status_label) {
        try {
            $sql = "SELECT * FROM $table_name WHERE $column_name LIKE '%$filter_value' AND status = '$status_label' ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getTableByUser($table_name, $column_name, $filter_value, $status_label) {
        try {
            $sql = "SELECT * FROM $table_name WHERE $column_name LIKE '%$filter_value' AND status = '$status_label' AND user_type != 'admin' ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    //Filter Students 
    public function getStudentBy($table_name, $column_name, $filter_value, $status_label) {
        try {
            $sql = "SELECT * FROM $table_name WHERE $column_name LIKE '%$filter_value' AND status = '$status_label' ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function makeUserAccount($user_id, $user_type, $email) {
        try {
            
            $password = $this->randomPassword();
            $status = "active";

            $sql = "INSERT INTO users (user_id, user_type, email, password, status) VALUES (:user_id, :user_type, :email, :password, :status) ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':user_id', $user_id);
            $stmt->bindparam(':user_type', $user_type);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':password', $password);
            $stmt->bindparam(':status', $status);
            $stmt->execute();
            return true;
            
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        }
        
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }
    

    public function getOffice($id) {
        try {

            $sql = "SELECT * FROM offices WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addOffice($office_name) {
        try {
            $status = "active";
            $sql = "INSERT INTO offices (office_name, status) VALUES (:office_name, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':office_name', $office_name);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id) {
        try {
            $status = "deleted";
            $sql = "UPDATE users SET status = :status WHERE user_id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteOffice($id) {
        try {

            $sql = "UPDATE offices SET status = 'inactive' WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
      
}