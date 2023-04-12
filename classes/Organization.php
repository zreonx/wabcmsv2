<?php

class Organization {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getOrganizations() {
        try {

            $sql = "SELECT * FROM organizations";
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
    
}