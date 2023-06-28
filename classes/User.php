<?php

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllUser() {
        try {

            $sql = "SELECT * FROM users WHERE status IN ('active', 'deactivated') and user_type NOT IN ('admin')";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentAccount() {
        try {

            $sql = "SELECT * FROM users WHERE status = 'active' AND user_type = 'student'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function makeUserAccount($user_id, $user_type, $email) {
        try {
            
            $password = $this->randomPassword();
            $status = "active";

            $sql = "INSERT INTO users (user_id, user_type, email, password, status) VALUES (:user_id, :user_type, :email, :password, :status) ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':user_id', $user_id);
            $stmt->bindparam(':user_type', $user_type);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':password', $password);
            $stmt->bindparam(':status', $status);
            $stmt->execute();
            return true;
            
        }catch(PDOException $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        }
        
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }

    public function getUserType($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = '$email' OR user_id = '$email' AND status = 'active' ";
            $result = $this->conn->query($sql);
            $user_type = $result->fetch(PDO::FETCH_ASSOC);
            
            return $user_type;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function loginUser($user_type, $email, $password) {
        try {

            if($user_type == "student"){
                $sql = 'SELECT * FROM users WHERE user_type = :type AND email = :email OR user_id = :email AND password = :password;';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindparam(':type', $user_type);
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':password', $password);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }else {
                $sql = 'SELECT * FROM users WHERE user_type = :type AND email = :email AND password = :password AND status = "active" ;';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindparam(':type', $user_type);
                $stmt->bindparam(':email', $email);
                $stmt->bindparam(':password', $password);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
           
            return $result;


        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
            
        }
        
    }

    public function getAdminInfo($user_id) {
        try {

            $sql = "SELECT * FROM admin WHERE admin_id = $user_id";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatoryInfo($user_id) {
        try {

            $sql = "SELECT * FROM signatories WHERE id = $user_id AND status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentInfo($user_id) {
        try {

            $sql = "SELECT * FROM students WHERE student_id = '$user_id' AND status IN ('imported','graduated')";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    // Change Password Functions

    public function checkUserType($user_id, $user_type) {
        try {
            $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND user_type = '$user_type' ;";
            $result = $this->conn->query($sql);

            $query = $result->fetch(PDO::FETCH_ASSOC);

            return $query;

        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getUserData($user_id, $user_type) {
        try {

            $userData = $this->checkUserType($user_id, $user_type);

            $userId = $userData['user_id'];
            $userType = $userData['user_type'];


            if($userType == 'student') {
                $sql = "SELECT * FROM students WHERE student_id = '$user_id' ;";
            }else if($userType == 'signatory') {
                $sql = "SELECT * FROM signatories WHERE id = '$user_id' ;";
            }else if($userType == 'admin') {
                $sql = "SELECT * FROM admin WHERE admin_id = '$user_id' ;";
            }
           

            $result = $this->conn->query($sql);
            $queryData = $result->fetch(PDO::FETCH_ASSOC);
            return array('userdata' => $queryData, 'old_pass' => $userData['password']) ;

        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function changePassword($user_id, $new_password) {
        try {

            $sql = "UPDATE users SET password = :new_password WHERE user_id = :user_id ;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':user_id', $user_id);
            $stmt->bindparam(':new_password', $new_password);
            $stmt->execute();
            return true;

        }catch(PDOException $e) {
            echo $e->getMessage();
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

    public function deleteUser($id) {
        try {
            $status = "deleted";
            $sql = "UPDATE users SET status = :status WHERE user_id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }


    public function deactivateAccount($id) {
        try {
            $status = "deactivated";
            $sql = "UPDATE users SET status = :status WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function activateAccount($id) {
        try {
            $status = "active";
            $sql = "UPDATE users SET status = :status WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getAllCourse() {
        try {

            $sql = "SELECT * FROM departments WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getAllSHS() {
        try {

            $sql = "SELECT * FROM shs WHERE status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getStudentAccounts($year_level, $program_course) {

        try {

            $sql = "SELECT * FROM students s INNER JOIN users u ON u.user_id = s.student_id  WHERE s.status = 'imported' AND s.year_level = '$year_level' AND s.program_course = '$program_course'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }

    }

    public function getSignatoryAccount() {
        try {

            $sql = "SELECT * FROM users u INNER JOIN signatories s ON u.user_id = s.id WHERE u.user_type = 'signatory' AND u.status = 'active'";
            $result = $this->conn->query($sql); 
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function allDesignation() {
        try {
            $sql = "SELECT * FROM designation_meta dm INNER JOIN designation_signatory ds ON dm.id = ds.designation_id INNER JOIN signatories s ON ds.signatory_id = s.id INNER JOIN users u ON s.id = u.user_id WHERE dm.status = 'active' AND ds.status = 'active'";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }




      
}