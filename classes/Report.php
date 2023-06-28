<?php

class Report {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

 
    public function getSignatoryAccount() {
        try {

            $sql = "SELECT * FROM users u INNER JOIN signatories s ON u.user_id = s.id WHERE u.user_type = 'signatory' AND u.status = 'active'";
            $result = $this->conn->query($sql); 
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allDesignation() {
        try {
            $sql = "SELECT * FROM designation_meta dm INNER JOIN designation_signatory ds ON dm.id = ds.designation_id INNER JOIN signatories s ON ds.signatory_id = s.id INNER JOIN users u ON s.id = u.user_id WHERE dm.status = 'active' AND ds.status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getClearanceInfo($clearance_id) {
        try {
            $sql = "SELECT * FROM clearances c INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE c.id = '$clearance_id'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getAllClearanceSignatory($clearance_id) {
        try {
            $sql = "SELECT * FROM designation_clearance_signatory dc INNER JOIN signatories s ON dc.signatory_id = s.id WHERE clearance_id = '$clearance_id' ORDER BY workplace";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getSignatoryStudents($table_name, $clearance_id) {
        try {
            $sql = "SELECT * FROM  $table_name tb INNER JOIN students s ON tb.student_id  COLLATE utf8mb4_general_ci = s.student_id  COLLATE utf8mb4_general_ci WHERE tb.clearance_id = '$clearance_id'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getAllClearance() {
        try {
            $sql = "SELECT * FROM  clearances c INNER JOIN clearance_type ct ON c.clearance_type = ct.id INNER JOIN clearance_beneficiaries cb ON c.clearance_beneficiary = cb.id INNER JOIN clearance_status cs ON c.id = cs.clearance_id  WHERE c.status = 'initialized'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }





      
}