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

    public function getCategories() {
        try {

            $sql = "SELECT * FROM designation_category WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
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
    public function getSpecificDesignation($designation_id) {
        try {
            $sql = "SELECT * FROM designation_meta WHERE id = '$designation_id' AND status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
     
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
            
            $sql = "INSERT INTO designation_meta (category, designation, signatory_workplace, status) VALUES (:category, :designation, :signatory_workplace, :status); ";
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
    public function getWorkplace($category, $workplace_id) {

           switch($category) {
                case "1": 
                    //Program Head
                    $office = $this->signatoryWorkplace("departments", "department_code", $workplace_id);
                    return $office['workplace'];
                break;
                case "2": 
                    $office = $this->signatoryWorkplace("offices", "office_name", $workplace_id);
                    return $office['workplace'];
                break;
                case "3": 
                    //SHS
                    $office = $this->signatoryWorkplace("shs", "strand", $workplace_id);
                    return $office['workplace'];
                break;
                case "4": 
                    //Org
                    $office = $this->signatoryWorkplace("organizations", "organization_code", $workplace_id);
                    return $office['workplace'];
                break;
                default: 
                    //
                break;
           }

    }

    public function signatoryWorkplace($workplace_table, $column, $workplace_id) {
        try {

            $sql = "SELECT $workplace_table.$column as 'workplace' FROM $workplace_table WHERE $workplace_table.id = $workplace_id";
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
            $sql = "SELECT * FROM signatories WHERE (id LIKE '%$searchData%' OR first_name LIKE '%$searchData%' OR last_name LIKE '%$searchData%' OR middle_name LIKE '%$searchData%' OR email LIKE '%$searchData%') AND status = 'active' ;";
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

    //Remove Signatory Assignment

    public function removeSignatoryDesignation($designation_id) {
        try {
            $status = 'removed';
            $sql = "UPDATE designation_signatory SET status = :status WHERE designation_id = :designation_id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':status', $status);
            $stmt->bindparam(':designation_id', $designation_id);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function removeDesignationTable($signatory_id, $table_name) {
        try {
            $status = 'removed';
            $sql = "UPDATE designation_table_record SET status = :status WHERE signatory_id = :signatory_id AND signatory_clearance_table_name = :table_name ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':status', $status);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':table_name', $table_name);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getDesignationTableById($signatory_id) {
        try {
            $status = 'active';
            $sql = "SELECT * FROM designation_table_record WHERE status = :status AND signatory_id = :signatory_id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':status', $status);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

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


    //Fetch all the designations with assigned signatories
    
    public function getAllAssignedDesignations() {
        try {

            $sql = "SELECT * FROM designation_signatory ds INNER JOIN designation_meta dm ON ds.designation_id = dm.id WHERE ds.status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Get designation information
    public function getDesignationInfo($designation_id) {
        try {

            $sql = "SELECT * FROM designation_signatory ds INNER JOIN designation_meta dm ON ds.designation_id = dm.id WHERE ds.designation_id = $designation_id AND ds.status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    public function ad_tbname() {
        
        $allDesignation = $this->getAllAssignedDesignations();

        $result = array();

        foreach($allDesignation as $des_val) {
            $signatory_worklace_name = $this->getWorkplace($des_val['category'], $des_val['signatory_workplace']);
            $signatory_id = $des_val['signatory_id'];
            $signatory_designation = $des_val['designation'];
            
            // Define key-value pairs in the associative array
            $result[] = array(
                'signatory_workplace_name' => $signatory_worklace_name,
                'signatory_id' => $signatory_id,
                'signatory_designation' => $signatory_designation
            );
        }

        return $result;
    }

    public function table_for_program_head() {
        
        $department = new Department($this->conn);

        $dept_query= $department->getDepartments();

        $dept_data = $dept_query->fetchAll(PDO::FETCH_ASSOC);

        $tbl_name = $this->ad_tbname();

        $tble_name_array = array();

        foreach($dept_data as $dept_val) {
            foreach($tbl_name as $phead_tbl) {
                if($dept_val['department_code'] == $phead_tbl['signatory_workplace_name']){
                    array_push($tble_name_array, $phead_tbl);
                }
            }
        }
        return $tble_name_array;
    }

    public function table_for_offices() {
        
        $office = new Offices($this->conn);

        $office_query = $office->getOffices();

        $office_data = $office_query->fetchAll(PDO::FETCH_ASSOC);

        $tbl_name = $this->ad_tbname();

        $tble_name_array = array();

        foreach($office_data as $office_val) {
            foreach($tbl_name as $office_tbl) {
                if($office_val['office_name'] == $office_tbl['signatory_workplace_name']){
                    array_push($tble_name_array, $office_tbl);
                }
            }
        }


        return $tble_name_array;
    }

    public function table_for_org() {
        
        $organization = new Organization($this->conn);

        $org_query = $organization->getOrganizations();

        $org_data = $org_query->fetchAll(PDO::FETCH_ASSOC);

        $tbl_name = $this->ad_tbname();

        $tble_name_array = array();

        foreach($org_data as $org_val) {
            foreach($tbl_name as $org_tbl) {
                if($org_val['organization_code'] == $org_tbl['signatory_workplace_name']){
                    array_push($tble_name_array, $org_tbl);
                }
            }
        }


        return $tble_name_array;
    }

    public function table_for_shs() {
        
        $shs = new SHS($this->conn);

        $shs_query = $shs->getStrands();

        $shs_data = $shs_query->fetchAll(PDO::FETCH_ASSOC);

        $tbl_name = $this->ad_tbname();

        $tble_name_array = array();

        foreach($shs_data as $shs_val) {
            foreach($tbl_name as $shs_tbl) {
                if($shs_val['strand'] == $shs_tbl['signatory_workplace_name']){
                    array_push($tble_name_array, $shs_tbl);
                }
            }
        }


        return $tble_name_array;
    }

    

    //Creating table for signatory designation clearance
    public function createSignatoryDesignationClearance($table_name) {
        try {

            $sql = "CREATE TABLE $table_name (
                id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                clearance_id varchar(11) NOT NULL,
                semester varchar(255) NOT NULL,
                academic_year varchar(255) NOT NULL,
                student_id varchar(255) NOT NULL,
                student_clearance_status varchar(255) NOT NULL,
                date_cleared varchar(255) NULL
             )";

            $result = $this->conn->exec($sql);
            return true;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    //Deleting designation development purposes
    public function deleteDesignationTable($table_name) {
        try {

            $sql = "DROP TABLE $table_name ; DELETE FROM designation_table_record; ";

            $result = $this->conn->exec($sql);
            return true;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Check if the signatory designation already have table
    public function checkTableNameExist($table_name) {
        try {

            $sql = "SELECT * FROM designation_table_record WHERE signatory_clearance_table_name = '$table_name';";
            $result = $this->conn->query($sql);
            if($result->rowCount() > 0) { 
                return true;
            }else {
                return false;
            }
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //check if table name was there before
    public function checkExistingRemovedTable($table_name) {
        try {

            $sql = "SELECT * FROM designation_table_record WHERE signatory_clearance_table_name = '$table_name' AND status = 'removed';";
            $result = $this->conn->query($sql);
            if($result->rowCount() > 0) { 
                return true;
            }else {
                return false;
            }
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Update removed clearance table

    public function reactivatePreviousSignatoryTable($table_name) {
        try {

            $sql = "UPDATE designation_table_record SET status = 'active' WHERE signatory_clearance_table_name = :table_name ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':table_name', $table_name);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function designationTableRecord() {
        try {

            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addSignatoryDesignationRecord($signatory_id, $signatory_workplace_name, $table_name) {
        try {
            $status = "active";
            $sql = "INSERT INTO designation_table_record (signatory_id, signatory_workplace_name, signatory_clearance_table_name, status) VALUES (:signatory_id, :signatory_workplace_name, :signatory_clearance_table_name, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':signatory_workplace_name', $signatory_workplace_name);
            $stmt->bindparam(':signatory_clearance_table_name', $table_name);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function designationProgramHead() {
        try {
            $sql = "SELECT * FROM designation_meta WHERE designation = 'Program Head' AND status = 'active'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }




}