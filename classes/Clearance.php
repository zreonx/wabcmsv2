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

            $sql = "SELECT *, c.id as 'clearance_id' FROM clearances c INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE c.status != 'deleted'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getBeneficiary($id) {
        try {

            $sql = "SELECT beneficiary FROM clearance_beneficiaries WHERE id = '$id'";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data['beneficiary'];
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    
    

    public function getClearanceInfo($id) {
        try {

            $sql = "SELECT *, c.status AS 'c_status' FROM clearances c INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE c.id = $id";
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

    public function createClearanceDesignation($clearance_id, $signatory_id, $workplace, $designation_table) {
        try {

            $status = "active";
            $sql = "INSERT INTO designation_clearance_signatory (clearance_id, signatory_id, workplace, designation_table, status) VALUES (:clearance_id, :signatory_id, :workplace, :designation_table, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':workplace', $workplace);
            $stmt->bindparam(':designation_table', $designation_table);
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

    //Deleteing clearance
    public function deleteClearance($id) {
        try {

            $sql = "UPDATE clearances SET status = 'deleted' WHERE id = :id ; UPDATE clearance_status SET status = 'deleted' WHERE clearance_id = :id ;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function selectClearanceStatusRecord($clearance_id) {
        try {

            $sql = "SELECT * FROM clearance_status WHERE clearance_id = '$clearance_id' AND status = 'active'";
            $result = $this->conn->query($sql);
            $record = $result->rowCount();
            return $record;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDeployedStudentInTable($signatory_table, $clearance_id) {
        try {

            $sql = "DELETE FROM $signatory_table WHERE clearance_id = '$clearance_id'";
            $result = $this->conn->query($sql);
            $record = $result->rowCount();
            return $record;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function selectActiveDesignationTable() {
        try {

            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
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

    public function selectCollegeStudent() {
        try {

            $sql = "SELECT * FROM students WHERE academic_level = 'college' AND status = 'imported'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function selectShsStudent() {
        try {

            $sql = "SELECT * FROM students WHERE academic_level = 'SHS' AND status = 'imported'";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function insertStudentToTable($table_name, $clearance_id, $semester, $academic_year, $student_id) {
        try {
            $status = "initialized";
            //$this->insertStudentClearanceRecord($clearance_id, $signatory_id, $table_name, $student_id, '1');

            $sql = "INSERT INTO $table_name (clearance_id, semester, academic_year, student_id, student_clearance_status, date_cleared) VALUES (:clearance_id, :semester, :academic_year, :student_id, '2', ''); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':semester', $semester);
            $stmt->bindparam(':academic_year', $academic_year);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->execute();
            
            
            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deployClearanceSignatories($clearance_id, $date_deploy) {
        try {
            $status = "initialized";
            $sql = "INSERT INTO clearance_status (clearance_id, date_deploy_signatory, date_deploy_student, date_ended, status) VALUES (:clearance_id, :date_deploy, '', '', 'active'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':date_deploy', $date_deploy);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deployClearanceStudent($clearance_id, $date_deploy) {
        try {
            $status = "initialized";
            $sql = "UPDATE clearance_status SET date_deploy_student = :date_deploy WHERE clearance_id = :clearance_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':date_deploy', $date_deploy);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function endClearance($clearance_id, $date_end) {
        try {
            $status = "ended";
            $sql = "UPDATE clearance_status SET date_ended = :date_end, status = :status WHERE clearance_id = :clearance_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':date_end', $date_end);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            $this->endClearanceStatus($clearance_id, $status);

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function endClearanceStatus($clearance_id, $status) {
        try {
            
            $sql = "UPDATE clearances SET status = :status WHERE clearance_id = :clearance_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function checkIsClearanceDeployed($id) {
        try {

            $sql = "SELECT * FROM clearance_status WHERE clearance_id = '$id' AND status IN ('active','ended')";
            $result = $this->conn->query($sql);
            $count = $result->rowCount();
            $query = $result->fetch(PDO::FETCH_ASSOC);
            return array('count' => $count, 'query' => $query);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getActiveClearance() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.status IN ('active','ended')";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    public function getPreviousClearance() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.status IN ('ended')";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getActiveClearanceSignatories() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.status IN ('active')";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }
    public function getPreviousClearanceSignatories() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.status IN ('ended')";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getActiveClearanceById($clearance_id) {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.clearance_id = '$clearance_id' AND cs.status IN ('active','ended')";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getActiveClearanceStudent() {
        try {
            $sql = "SELECT * FROM clearance_status cs INNER JOIN clearances c ON cs.clearance_id = c.id INNER JOIN clearance_type ct ON c.clearance_type = ct.id WHERE cs.status = 'active' AND cs.date_deploy_student != ''; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatoryDesignationTable($signatory_id) {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE signatory_id = '$signatory_id' AND status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getClearanceSignatoryDesignationTable($clearance_id, $signatory_id) {
        try {
            $sql = "SELECT * FROM designation_clearance_signatory WHERE clearance_id = $clearance_id AND signatory_id = '$signatory_id' AND status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatoryDesignationTableStudent($table_name, $clearance_id) {
        try {
            $sql = "SELECT * FROM $table_name tb INNER JOIN students s ON tb.student_id = s.student_id COLLATE utf8mb4_general_ci WHERE tb.clearance_id = '$clearance_id' COLLATE utf8mb4_general_ci";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function addStudentDeficiency($clearance_id, $signatory_table, $student_id, $message, $date_notify) {
        try {
            $status = "initialized";
            $sql = "INSERT INTO deficiencies (clearance_id, signatory_table, student_id, message, date_notify, date_cleared, status) VALUES (:clearance_id, :signatory_table, :student_id, :message, :date_notify, '', 'deficient'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':signatory_table', $signatory_table);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->bindparam(':message', $message);
            $stmt->bindparam(':date_notify', $date_notify);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function unclearDeficientStudent($designation_table, $clearance_id, $student_id) {
        try {

            $sql = "UPDATE $designation_table SET student_clearance_status = '0' WHERE clearance_id = :clearance_id AND student_id = :student_id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':student_id', $student_id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function clearDeficientStudent($designation_table, $clearance_id, $student_id, $date_cleared) {
        try {

            $sql = "UPDATE deficiencies SET date_cleared = :date_cleared, status='cleared' WHERE clearance_id = :clearance_id AND student_id = :student_id AND signatory_table = :designation_table ; UPDATE clearance_student_record SET clearance_status = '1' WHERE clearance_id = :clearance_id AND student_id = :student_id AND signatory_table = :designation_table ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->bindparam(':date_cleared', $date_cleared);
            $stmt->bindparam(':designation_table', $designation_table);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function cleaStudentDeficiency($designation_table, $clearance_id, $student_id, $date_cleared) {
        try {

            $sql = "UPDATE $designation_table SET student_clearance_status = '1', date_cleared = :date_cleared WHERE clearance_id = :clearance_id AND student_id = :student_id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->bindparam(':date_cleared', $date_cleared);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getUnclearedStudents($table_name, $clearance_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE clearance_id = '$clearance_id' AND student_clearance_status IN ('2','0') ; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //Get All Deficiency of student
    public function getStudentDeficiency($table_name, $clearance_id, $student_id) {
        try {
            $sql = "SELECT * FROM deficiencies WHERE clearance_id = '$clearance_id' AND student_id = '$student_id' AND signatory_table = '$table_name'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function createSignatoryDeficiencySubmission($clearance_id) {
        try {
            $status = "initialized";
            $sql = "INSERT INTO clearance_signatory_deficiency_status (clearance_id, status) VALUES (:clearance_id, 'incomplete'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function insertSignatoryDeficiencyStatus($cd_id, $signatory_id, $signatory_table, $date_submit) {
        try {
            $status = "active";
            $sql = "INSERT INTO clearance_signatory_deficiency_record (cd_id, signatory_id, signatory_table, date_submit, cd_status, status) VALUES (:cd_id, :signatory_id, :signatory_table, :date_submit, '', '$status'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':cd_id', $cd_id);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':signatory_table', $signatory_table);
            $stmt->bindparam(':date_submit', $date_submit);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function checkDeficiencySubmission($clearance_id) {
        try {

            $sql = "SELECT * FROM clearance_signatory_deficiency_status WHERE clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            $record = $result->rowCount();
            return $record;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getDeficiencySubmissionId($clearance_id) {
        try {

            $sql = "SELECT * FROM clearance_signatory_deficiency_status WHERE clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function checkDeficiencySubmitStatus($clearance_id, $designation_table) {
        try {
            $sql = "SELECT *, cs.status AS 'cs_status' FROM clearance_signatory_deficiency_status cs INNER JOIN clearance_signatory_deficiency_record cr ON cs.id = cr.cd_id AND cr.signatory_table = '$designation_table' WHERE cs.clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function submitDeficiency($designation_table, $cd_id, $date_submit) {
        try {

            $sql = "UPDATE clearance_signatory_deficiency_record SET cd_status  = '1', date_submit = :date_submit WHERE cd_id = :cd_id AND signatory_table = :signatory_table ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':cd_id', $cd_id);
            $stmt->bindparam(':signatory_table', $designation_table);
            $stmt->bindparam(':date_submit', $date_submit);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function cancelSubmitDeficiency($designation_table, $cd_id, $date_submit) {
        try {

            $date_submit = '';
            $sql = "UPDATE clearance_signatory_deficiency_record SET cd_status  = '', date_submit = :date_submit WHERE cd_id = :cd_id AND signatory_table = :signatory_table ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':cd_id', $cd_id);
            $stmt->bindparam(':signatory_table', $designation_table);
            $stmt->bindparam(':date_submit', $date_submit);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatorySubmitStatus($clearance_id) {
        try {
            $sql = "SELECT * FROM clearance_signatory_deficiency_record cr INNER JOIN clearance_signatory_deficiency_status cs ON cs.id = cr.cd_id INNER JOIN designation_table_record dr ON cr.signatory_table = dr.signatory_clearance_table_name COLLATE utf8mb4_general_ci WHERE cs.clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatoryDesignation($signatory_id) {
        try {
            $sql = "SELECT * FROM designation_signatory ds INNER JOIN designation_meta dm ON ds.designation_id = dm.id WHERE ds.signatory_id = '$signatory_id' AND ds.status = 'active'; ";
            $result = $this->conn->query($sql);
            
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allStudentTakingClearance() {
        try {
            $sql = "SELECT * FROM students WHERE status = 'imported'; ";
            $result = $this->conn->query($sql);
            
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getActiveSignatoryDesignation() {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'; ";
            $result = $this->conn->query($sql);
            
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function activeSignatoryTableData($table_name, $clearance_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            
            return $result->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function insertStudentClearanceRecord($clearance_id, $signatory_id, $signatory_designation_table, $student_id, $clearance_status) {
        try {
            $status = "active";
            $sql = "INSERT INTO clearance_student_record (clearance_id, signatory_id, signatory_designation_table, student_id, clearance_status, status) VALUES (:clearance_id, :signatory_id, :signatory_designation_table, :student_id, :clearance_status, 'active'); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':signatory_id', $signatory_id);
            $stmt->bindparam(':signatory_designation_table', $signatory_designation_table);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->bindparam(':clearance_status', $clearance_status);
            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentClearanceStatus($table_name, $clearance_id, $student_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE clearance_id = '$clearance_id' AND student_id = '$student_id' ; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function cleareStudentClearanceRecord($table_name, $clearance_id, $student_id) {
        try {
            $sql = "UPDATE clearance_student_record SET clearance_status = '1' WHERE signatory_designation_table = :signatory_designation_table AND clearance_id = :clearance_id AND student_id = :student_id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':clearance_id', $clearance_id);
            $stmt->bindparam(':signatory_designation_table', $table_name);
            $stmt->bindparam(':student_id', $student_id);
            $stmt->execute();

            return true;
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    // Student Clearance

    
    public function getDepartmentClearance($table_name, $clearance_id, $student_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE clearance_id = '$clearance_id' AND student_id = '$student_id' ; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allActiveSignatories() {
        try {
            $sql = "SELECT * FROM designation_meta dm INNER JOIN designation_signatory ds ON dm.id = ds.designation_id WHERE ds.status = 'active' and dm.status = 'active'; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allActiveSignatoryTable() {
        try {
            $sql = "SELECT * FROM designation_table_record WHERE status = 'active'; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allActiveSignatoryTableById($clearance_id) {
        try {
            $sql = "SELECT * FROM designation_clearance_signatory WHERE clearance_id = '$clearance_id'AND status = 'active'; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    //for org
    public function allActiveSignatoryTableOrg() {
        try {
            $sql = "SELECT * FROM designation_table_record dr INNER JOIN organizations o ON dr.signatory_workplace_name = o.organization_code WHERE dr.status = 'active' AND dr.signatory_workplace_name = o.organization_code; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allActiveSignatoryTableOrgById($clearance_id) {
        try {
            $sql = "SELECT * FROM designation_clearance_signatory dr INNER JOIN organizations o ON dr.workplace COLLATE utf8mb4_general_ci = o.organization_code  WHERE dr.status = 'active' AND dr.workplace COLLATE utf8mb4_general_ci = o.organization_code AND dr.clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getStudentCourseId($department) {
        try {
            $sql = "SELECT * FROM departments WHERE department_code = '$department' AND status = 'active'";
            $result = $this->conn->query($sql);
            $response = $result->fetch(PDO::FETCH_ASSOC);
            return $response['id'];
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function checkIfCleared($table_name, $student_id, $clearance_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE student_id = '$student_id' AND clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function checkIfStudentIsInside($table_name, $student_id, $clearance_id) {
        try {
            $sql = "SELECT * FROM $table_name WHERE student_id = '$student_id' AND clearance_id = '$clearance_id'; ";
            $result = $this->conn->query($sql);
            return $result->rowCount();
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentClearance($clearance_id) {
        try {
            $sql = "SELECT csr.student_id FROM clearance_student_record csr WHERE clearance_id = '$clearance_id' GROUP BY student_id";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentInfo($student_id) {
        try {
            $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function getPersonalClearance($clearance_id, $student_id) {
        try {
            $sql = "SELECT student_id, clearance_id FROM clearance_student_record WHERE student_id = '$student_id' AND clearance_id = '$clearance_id'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    




}