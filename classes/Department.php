<?php

class Department {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getDepartments() {
        try {

            $sql = "SELECT * FROM departments WHERE status !=  'inactive'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    

    public function getDepartment($id) {
        try {

            $sql = "SELECT * FROM departments WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addDepartment($department_code, $department_name) {
        try {

            $sql = "INSERT INTO departments (department_code, department_name, program_head_id, status) VALUES (:dept_code, :dept_name, '', 'active'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':dept_code', $department_code);
            $stmt->bindparam(':dept_name', $department_name);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function updateDepartment($id, $department_code, $department_name) {
        try {

            $sql = "UPDATE departments SET department_code = :dept_code, department_name = :dept_name WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':dept_code', $department_code);
            $stmt->bindparam(':dept_name', $department_name);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDepartment($id) {
        try {

            $sql = "UPDATE departments SET status = 'inactive' WHERE id = :id ; ";
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