<?php

class Offices {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getOffices() {
        try {

            $sql = "SELECT * FROM offices WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
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

    public function updateOffice($id, $office_name) {
        try {

            $sql = "UPDATE offices SET office_name = :office_name WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':office_name', $office_name);

            $stmt->bindparam(':id', $id);

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