<?php

class Signatory {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getSignatories() {
        try {

            $sql = "SELECT * FROM signatories WHERE status !=  'inactive'";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getSignatoryDesignations($id) {
        try {

            $sql = "SELECT * FROM designation_signatory ds INNER JOIN designation_meta dm ON ds.designation_id = dm.id WHERE ds.status !=  'inactive' AND ds.signatory_id = '$id';";
            $result = $this->conn->query($sql);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;

            // $datas = array();
            
            // while($data = $result->fetch(PDO::FETCH_ASSOC)){
            //     if(!empty($data)){
            //         return array('category' => $data['category'], 'signatory_workplace' => $data['signatory_workplace']);
            //     }else {
            //         return false;
            //     }
            // }
            
            
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
    

    public function getSignatory($id) {
        try {

            $sql = "SELECT * FROM signatories WHERE id = $id";
            $result = $this->conn->query($sql);
            return $result;
            
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function addSignatory($firstname, $middlename, $lastname, $email) {
        try {
            $status = "active";
            $sql = "INSERT INTO signatories (first_name, middle_name, last_name, email, status) VALUES (:first_name, :middle_name, :last_name, :email, :status); ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':first_name', $firstname);
            $stmt->bindparam(':middle_name', $middlename);
            $stmt->bindparam(':last_name', $lastname);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':status', $status);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function updateSignatory($id, $firstname, $middlename, $lastname, $email) {
        try {

            $sql = "UPDATE signatories SET first_name = :firstname, middle_name = :middlename, last_name = :lastname, email = :email WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':firstname', $firstname);
            $stmt->bindparam(':middlename', $middlename);
            $stmt->bindparam(':lastname', $lastname);
            $stmt->bindparam(':email', $email);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function deleteSignatory($id) {
        try {

            $sql = "UPDATE signatories SET status = 'inactive' WHERE id = :id ; ";
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