<?php

class Dashboard {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function allStudents() {
        try {

            $sql = "SELECT * FROM students WHERE status != 'inactive'";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            return $count;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function assignedSignatories() {
        try {

            $sql = "SELECT * FROM designation_signatory WHERE status != 'removed'";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            return $count;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allDesignation() {
        try {

            $sql = "SELECT * FROM designation_meta WHERE status != 'removed'";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            return $count;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allClearance() {
        try {

            $sql = "SELECT * FROM clearances WHERE status != 'deleted'";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            return $count;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getAllOrganizations() {
        try {

            $sql = "SELECT * FROM organizations WHERE status != 'inactive'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    public function getWorkplace() {
        try {

            $sql = "SELECT COUNT(*) as 'org_count', 
            (SELECT COUNT(*) FROM departments WHERE status != 'inactive') as 'dept_count',
            (SELECT COUNT(*) FROM offices WHERE status != 'inactive') as 'ofc_count',
            (SELECT COUNT(*) FROM shs WHERE status != 'inactive') as 'shs_count'
            FROM organizations WHERE status != 'inactive' ";

            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    

    public function getOrganization($id) {
        try {

            $sql = "SELECT * FROM organizations WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addOrganization($organization_code, $organization_name) {
        try {

            $sql = "INSERT INTO organizations (organization_code, organization_name) VALUES (:organization_code, :organization_name); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':organization_code', $organization_code);
            $stmt->bindparam(':organization_name', $organization_name);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function updateOrganization($id, $organization_code, $organization_name) {
        try {

            $sql = "UPDATE organizations SET organization_code = :org_code, organization_name = :org_name WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':org_code', $organization_code);
            $stmt->bindparam(':org_name', $organization_name);
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


    // Students

    public function studentClearanceData($clearance_id, $student_id) {
        try {
            $sql = "SELECT * FROM clearance_student_record WHERE student_id = '$student_id' AND clearance_id = '$clearance_id'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    
    
}