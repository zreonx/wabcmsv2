<?php

class Designation {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getCategory() {
        try {

            $sql = "SELECT * FROM designation_category WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getAllDesignationData() {
        try {
            $sql = "SELECT * FROM designation_meta WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getDesignationData($designation_id) {
        try {
            $sql = "SELECT *, (SELECT cagetory FROM designation_categories ds WHERE ds.id = dm.id ) as 'workplace FROM designation_meta dm WHERE id = $designation_id ; ";
            $result = $this->conn->query($sql);
            $designationInfo = $result->fetchAll(PDO::FETCH_ASSOC);
            return $designationInfo;
     
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

    public function addDesignation($category, $designation, $signatory_workplace) {
        try {
            $status = "active";
            
            $sql = "INSERT INTO designation_meta (category, designation, signatory_id, signatory_workplace, status) VALUES (:category, :designation, '', :signatory_workplace, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':category', $category);
            $stmt->bindparam(':designation', $designation);
            $stmt->bindparam(':signatory_workplace', $signatory_workplace);
            $stmt->bindparam(':status', $status);

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

    

    
    //Getting the dessignation category
    public function getWorkplace($category) {

        $designation_category = new DesignationCategory($this->conn);

        $categories = $designation_category->getDesignationCategories();
        while($cat_row = $categories->fetch(PDO::FETCH_ASSOC)) {
           switch($category) {
                case "1": 
                    //Program Head
                    $office = $this->signatoryWorkplace($category, "departments", "department_code");
                    return $office['workplace'];
                break;
                case "2": 
                    $office = $this->signatoryWorkplace($category, "offices", "office_name");
                    return $office['workplace'];
                break;
                case "3": 
                    //SHS
                    $office = $this->signatoryWorkplace($category, "shs", "strand");
                    return $office['workplace'];
                break;
                case "4": 
                    //Org
                    $office = $this->signatoryWorkplace($category, "organizations", "organization_code");
                    return $office['workplace'];
                break;
                default: 
                    //
                break;
           }
        }

    }

    public function officeWorkplace() {
        try {

            $sql = "SELECT *, (SELECT offices.office_name FROM offices WHERE offices.id = DM.signatory_workplace) AS 'workplace' FROM designation_meta DM";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function signatoryWorkplace($category, $workplace_table, $column) {
        try {

            $sql = "SELECT *, (SELECT $workplace_table.$column FROM $workplace_table WHERE $workplace_table.id = DM.signatory_workplace) AS 'workplace' FROM designation_meta DM WHERE DM.category = '$category'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    //Search Function 
    public function searchSignatory($searchData) {
        try {
            $sql = "SELECT * FROM signatories WHERE id LIKE '%$searchData%' OR first_name LIKE '%$searchData%' OR last_name LIKE '%$searchData%' OR middle_name LIKE '%$searchData%' OR email LIKE '%$searchData%' AND status = 'active' ;";
            $result = $this->conn->query($sql);
            return $result;
        }catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    //Assigning Signatory
    public function assignDesignation($designation_id, $signatory_id, $date_assigned) {
        try {
            $status = "active";
            $sql = "INSERT INTO designation_signatory (designation_id, signatory_id, date_assigned, date_removed, status) VALUES (:designation_id, :signatory_id, :date_assigned, '', :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':designation_id', $designation_id);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':date_assigned', $date_assigned);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Getting Signatory Information

     public function getSignatoryInformation($ds_id) {
        try {

            $sql = "SELECT * FROM designation_signatory ds INNER JOIN signatories s ON ds.signatory_id = s.id WHERE ds.designation_id = '$ds_id' AND ds.status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }



    
    
}