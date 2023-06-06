<?php
    if(isset($_POST['submit'])) {

        $student_id = $_POST['student_id'];
        $clearance_type_id = $_POST['clearance_type'];
        $reason_of_request = $_POST['request_reason'];
        date_default_timezone_set("Asia/manila");
        $date_request = date("Y-m-d H:i:s");
        

        require_once '../config/connection.php';
        

        if(!empty($clearance_type_id)){
            $result = $request->sendRequest($clearance_type_id, $student_id, $reason_of_request, $date_request);
        }

        if($result) {
            header("location: ../student/request_clearance.php?request_send=success");
        }else{
            header("location: ../student/request_clearance.php?request_send=failed");
        }
    }
?>