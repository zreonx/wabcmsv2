<?php

class Clearance {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getClearanceType() {
        try {

            $sql = "SELECT * FROM clearance_type WHERE status != 'inactive'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getBeneficiaries() {
        try {

            $sql = "SELECT * FROM clearance_beneficiaries WHERE status != 'inactive'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getAllClearance() {
        try {

            $sql = "SELECT *, c.id as 'clearance_id' FROM clearances c INNER JOIN clearance_beneficiaries cb ON c.clearance_beneficiary = cb.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE c.status != 'deleted'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    

    public function getClearanceInfo($id) {
        try {

            $sql = "SELECT * FROM clearances c INNER JOIN clearance_beneficiaries cb ON c.clearance_beneficiary = cb.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE c.id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function createClearance($clearance_beneficiary, $clearance_type, $semester, $academic_year, $date_created) {
        try {
            $status = "initialized";
            $sql = "INSERT INTO clearances (clearance_beneficiary, clearance_type, semester, academic_year, date_created, status) VALUES (:clearance_beneficiary, :clearance_type, :semester, :academic_year, :date_created, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_beneficiary', $clearance_beneficiary);
            $stmt->bindparam(':clearance_type', $clearance_type);
            $stmt->bindparam(':semester', $semester);
            $stmt->bindparam(':academic_year', $academic_year);
            $stmt->bindparam(':date_created', $date_created);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    // public function createClearanceStatus($clearance_id) {
    //     try {

    //         $status = "initialized";
    //         $sql = "INSERT INTO clearances (clearance_id, date_deploy_signatory, date_deploy_student, date_ended, status) VALUES (:clearance_id, '', '', '', :status); ";
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->bindparam(':clearance_beneficiary', $clearance_beneficiary);
    //         $stmt->bindparam(':clearance_type', $clearance_type);
    //         $stmt->bindparam(':semester', $semester);
    //         $stmt->bindparam(':academic_year', $academic_year);
    //         $stmt->bindparam(':date_created', $date_created);
    //         $stmt->bindparam(':status', $status);

    //         $stmt->execute();

    //         return true;

    //     }catch(PDOException $e) {
    //         echo "ERROR: " . $e->getMessage();
    //         return false;
    //     }
    // }

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

    public function deleteClearance($id) {
        try {

            $sql = "UPDATE clearances SET status = 'deleted' WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Deploying clearance for signatories

    public function selectAllStudents() {
        try {

            $sql = "SELECT * FROM students WHERE status = 'imported'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function insertStudentToTable($table_name, $clearance_id, $semester, $academic_year, $student_id, $date_cleared) {
        try {
            $status = "initialized";
            $sql = "INSERT INTO $table_name (clearance_id, semester, academic_year, student_id, student_clearance_status, date_cleared) VALUES (:clearance_id, :semester, :academic_year, :student_id, '1', :date_cleared); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':semester', $semester);
            $stmt->bindparam(':academic_year', $academic_year);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->bindparam(':date_cleared', $date_cleared);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    
    
}