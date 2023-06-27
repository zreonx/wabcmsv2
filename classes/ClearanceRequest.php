<?php

class ClearanceRequest {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getAvailableForRequest() {
        try {

            $sql = "SELECT * FROM clearance_type WHERE status = 'active' AND clearance_name NOT IN ('Finals Clearance')";
            $result = $this->conn->query($sql);
            return $result;
     
        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function getRequestRecord($student_id){
        try {
            $sql = "SELECT *, CR.id as 'request_id', CR.status as 'request_status' FROM clearance_requests CR INNER JOIN clearance_type CT ON CR.clearance_type_id = CT.id WHERE CR.status in ('pending', 'rejected', 'issued') AND CR.student_id = '$student_id'; ";
            $result = $this->conn->query($sql);
            return $result;
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllRequestRecord(){
        try {
            $sql = "SELECT *, CR.id as 'request_id', CR.status as 'request_status' FROM clearance_requests CR INNER JOIN clearance_type CT ON CR.clearance_type_id = CT.id INNER JOIN students s ON CR.student_id COLLATE utf8mb4_general_ci = s.student_id COLLATE utf8mb4_general_ci WHERE CR.status in ('pending', 'rejected', 'issued'); ";
            $result = $this->conn->query($sql);
            return $result;
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRequestInfo($request_id, $student_id){
        try {
            $sql = "SELECT *, CR.id as 'request_id', CR.status as 'request_status' FROM clearance_requests CR INNER JOIN clearance_type CT ON CR.clearance_type_id = CT.id WHERE CR.status in ('pending', 'rejected', 'issued') AND CR.student_id = '$student_id' AND CR.id = '$request_id'; ";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function sendRequest($clearance_type_id, $student_id, $reason_of_request, $date_requested) {
        try {

            $sql = "INSERT INTO clearance_requests (clearance_type_id, student_id, reason_of_request, date_requested, date_issued, status) VALUES (:clearance_type_id, :student_id, :reason_of_request, :date_requested, '', 'pending') ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(":clearance_type_id", $clearance_type_id);
            $stmt->bindparam(":student_id", $student_id);
            $stmt->bindparam(":reason_of_request", $reason_of_request);
            $stmt->bindparam(":date_requested", $date_requested);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function cancelRequest($id) {
        try {

            $sql = "UPDATE clearance_requests SET status = 'cancelled' WHERE id = :id ; ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(':id', $id);

            $stmt->execute();

            return true;

        }catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    public function rejectRequest($id) {
        try {

            $sql = "UPDATE clearance_requests SET status = 'rejected' WHERE id = :id ; ";
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