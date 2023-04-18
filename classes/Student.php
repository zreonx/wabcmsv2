<?php

class Student {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getStudents() {
        try {

            $sql = "SELECT * FROM students WHERE status = 'imported'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function importStudent ($columns = array()) {
        try {
            $status = "imported";
            //Get an associative array column associates
            $column_name = implode(', ', array_keys($columns));
            $column_value = implode("', '", $columns) . "', 'imported'";
            $sql_column = "($column_name, status)";

            
            $sql = "INSERT INTO students $sql_column VALUES ('$column_value) ON DUPLICATE KEY UPDATE contact_number = '$columns[contact_number]', program_course = '$columns[program_course]', academic_level = '$columns[academic_level]', year_level = '$columns[year_level]' ; ";

            $this->conn->exec($sql);
            //print_r($sql);
            return true;
            
        }catch(PDOException $e){
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