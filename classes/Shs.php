<?php

class Shs {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getStrands() {
        try {

            $sql = "SELECT * FROM shs WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    

    public function getStrand($id) {
        try {

            $sql = "SELECT * FROM shs WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addStrand($strand, $description) {
        try {
            $status = "active";
            $sql = "INSERT INTO shs (strand, description, status) VALUES (:strand, :description, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':strand', $strand);
            $stmt->bindparam(':description', $description);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function updateStrand($id, $strand, $description) {
        try {

            $sql = "UPDATE shs SET strand = :strand, description = :description WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':strand', $strand);
            $stmt->bindparam(':description', $description);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteOrg($id) {
        try {

            $sql = "UPDATE organizations SET status = 'inactive' WHERE id = :id ; ";
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