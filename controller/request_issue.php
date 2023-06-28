<?php
    if(isset($_POST['request_id'])){
        $request_id = $_POST['request_id'];
        $student_id = $_POST['student_id'];
        $semester = $_POST['semester'];
        $academic_year = $_POST['academic_year'];
        $clearance_type = 2;

        date_default_timezone_set("Asia/manila");
        $date_issued = date("Y-m-d H:i:s");

        echo $semester . $academic_year;

        require_once '../config/connection.php';

        
        $creation = $clearance->createClearance($student_id, $clearance_type, $semester, $academic_year, $date_issued);

        $result = $request->issueRequest($request_id, $date_issued);


        // if($result){
        //     header('location: ../admin/clearance_request.php?issue=success');
        // }else {
        //     header('location: ../admin/');
        // }

    
    } 
?>