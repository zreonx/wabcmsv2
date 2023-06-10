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


    public function getActiveClearance() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.date_deploy_signatory != '' AND cs.date_deploy_student != '' AND cs.status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getAllDesignation() {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'";
            $result = $this->conn->query($sql);
            $allRecords = $result->fetchAll(PDO::FETCH_ASSOC);

            $workplace_names = array();

            for($i = 0; $i < count($allRecords); $i++) {
                //echo strtoupper(str_replace("_", " ", substr($allRecords[$i]['signatory_clearance_table_name'], 3, -2)))
                $workplace_names[$i] = strtoupper(str_replace("_", " ", substr($allRecords[$i]['signatory_clearance_table_name'], 4, -2)));
            }

            $response = json_encode($workplace_names);

            return $response;


     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allSignatories() {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'";
            $result = $this->conn->query($sql);
            $allRecords = $result->fetchAll(PDO::FETCH_ASSOC);

            return $allRecords;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allSignatoryTable() {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'";
            $result = $this->conn->query($sql);
            $allRecords = $result->fetchAll(PDO::FETCH_ASSOC);

            return $allRecords;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allSignatoryProgress($clearance_id) {
        try {

            $allSignatory = $this->allSignatoryTable();

            $all = 0;
            $deficient = 0;
            $unsigned = 0;
            $cleared = 0;
            $unclear = 0;

            $percentage = 0;

            $signatory_percentage = array();
            $i = 0;
            foreach($allSignatory as $sig){
               
                $table_name = $sig['signatory_clearance_table_name'];
                $sql = "SELECT * FROM $table_name WHERE clearance_id =  '$clearance_id'; ";
                $result = $this->conn->query($sql);
                $students = $result->fetchAll(PDO::FETCH_ASSOC);

                
                $all = 0;
                $deficient = 0;
                $unsigned = 0;
                $cleared = 0;

               

                $percentage = 0;

                $all = count($students);
                foreach($students as $stud){
                    if($stud['student_clearance_status'] == '1'){
                        $cleared++;
                    }else if($stud['student_clearance_status'] == '0'){
                        $deficient++;
                    }else if($stud['student_clearance_status'] == '2'){
                        $unsigned++;
                    }
                }
                $unclear = $deficient + $unsigned;

                if($unclear == 0){
                    $percentage = 100;
                }else {
                    $percentage = ($unclear / $all) * 100;
                }


                
                $signatory_percentage[$i] = round($percentage);
                $i++;

                //print_r($sig['signatory_clearance_table_name'] . " - " . round($percentage) . "%\n");
            }

            return $signatory_percentage;

    
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function sinatoryStatus($clearance_id) {
        try {

            $activeSignatory = $this->allSignatories();

            $response = 

            $all = 0;
            $deficient = 0;
            $unsigned = 0;
            $cleared = 0;
            $unclear = 0;
            $alltotal = 0;

            $percentage = 0;

            foreach($activeSignatory as $sig) {
                $table_name = $sig['signatory_clearance_table_name'];
                $sql = "SELECT COUNT(*) as 'deficient' FROM $table_name WHERE student_clearance_status = '0' AND clearance_id = '$clearance_id'; ";
                $result = $this->conn->query($sql);
                $query = $result->fetch(PDO::FETCH_ASSOC);
                $deficient += $query['deficient'];
            }

            foreach($activeSignatory as $sig) {
                $table_name = $sig['signatory_clearance_table_name'];
                $sql = "SELECT COUNT(*) as 'unsigned' FROM $table_name WHERE student_clearance_status = '2' AND clearance_id = '$clearance_id'; ";
                $result = $this->conn->query($sql);
                $query = $result->fetch(PDO::FETCH_ASSOC);
                $unsigned += $query['unsigned'];
            }

            foreach($activeSignatory as $sig) {
                $table_name = $sig['signatory_clearance_table_name'];
                $sql = "SELECT COUNT(*) as 'cleared' FROM $table_name WHERE student_clearance_status = '1' AND clearance_id = '$clearance_id'; ";
                $result = $this->conn->query($sql);
                $query = $result->fetch(PDO::FETCH_ASSOC);
                $cleared += $query['cleared'];
            }

            foreach($activeSignatory as $sig) {
                $table_name = $sig['signatory_clearance_table_name'];
                $sql = "SELECT COUNT(*) as 'all' FROM $table_name WHERE clearance_id = '$clearance_id'; ";
                $result = $this->conn->query($sql);
                $query = $result->fetch(PDO::FETCH_ASSOC);
                $all += $query['all'];
                $alltotal += $query['all'];
            }

            
            $deficient = round(($deficient / $all) * 100);
            $cleared = round(($cleared / $all) * 100);
            $unsigned = round(($unsigned / $all) * 100);
           
            $all = round(($all / $all) * 100);

            return array('deficient' => $deficient, 'cleared' => $cleared, 'unsigned' => $unsigned, 'all' => $all, 'total' => $alltotal);

     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    
    
}