<?php

class Organization {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getOrganizations() {
        try {

            $sql = "SELECT * FROM organizations WHERE status != 'inactive'";
            $result = $this->conn->query($sql);
            return $result;
     
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
    

    public function getOrganization($id) {
        try {

            $sql = "SELECT * FROM  organizations WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getOrganizationLinked($id) {
        try {

            $sql = "SELECT * FROM  organizations o INNER JOIN departments d ON o.linked_department = d.id WHERE o.id = $id";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addOrganization($organization_code, $organization_name, $linked_department) {
        try {

            $sql = "INSERT INTO organizations (organization_code, organization_name, linked_department, status) VALUES (:organization_code, :organization_name, :linked_department, 'active'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':organization_code', $organization_code);
            $stmt->bindparam(':organization_name', $organization_name);
            $stmt->bindparam(':linked_department', $linked_department);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function updateOrganization($id, $organization_code, $organization_name, $linked_department) {
        try {

            $sql = "UPDATE organizations SET organization_code = :org_code, organization_name = :org_name, linked_department = :linked_department WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':org_code', $organization_code);
            $stmt->bindparam(':org_name', $organization_name);
            $stmt->bindparam(':linked_department', $linked_department);
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

    public function alreadyLinkedDepartment() {
        try {

            $sql = "SELECT * FROM organizations WHERE status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function orgLinkedDepartmentInformation($department_id) {
        try {
            $sql = "SELECT * FROM organizations WHERE linked_department = '$department_id' AND status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getOrganizationCategoryId($category) {
        try {
            $sql = "SELECT * FROM designation_category WHERE category = '$category' AND status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getOrganizationSignatory($category_id, $signatory_id) {
        try {
            $sql = "SELECT * FROM designation_signatory ds INNER JOIN designation_meta dm ON ds.designation_id = dm.id INNER JOIN organizations o ON dm.signatory_workplace = o.id WHERE ds.signatory_id = '$signatory_id' AND dm.category = '$category_id' AND ds.status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getOrgMember($organization_code) {
        try {
            $sql = "SELECT *, om.status FROM organization_member om INNER JOIN students s ON om.student_id COLLATE utf8mb4_general_ci = s.student_id COLLATE utf8mb4_general_ci WHERE org_code = '$organization_code' AND om.status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addOrganizationMember($org_id, $org_code, $student_id) {
        try {

            $sql = "INSERT INTO organization_member (org_id, org_code, student_id, status) VALUES (:org_id, :org_code, :student_id, 'active'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':org_id', $org_id);
            $stmt->bindparam(':org_code', $org_code);
            $stmt->bindparam(':student_id', $student_id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    
    
    
    
}