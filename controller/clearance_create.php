<?php
    if(isset($_POST['submit'])) {

        $clearance_beneficiary = $_POST['clearance_beneficiary'];

        $clearance_type =  $_POST['clearance_type'];
        $semester =  $_POST['semester'];
        $academic_year =  $_POST['academic_year'];

        date_default_timezone_set('Asia/Manila');

        $date_created = date('Y-m-d H:i:s');


        require_once '../config/connection.php';
        
        $result = $clearance->createClearance($clearance_beneficiary, $clearance_type, $semester, $academic_year, $date_created);

        if($result) {
            header('location: ../admin/clearance_management.php?success');
        }else {
            header('location: ../admin/clearance_management.php?failed');
        }
    }
?>