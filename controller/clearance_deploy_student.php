<?php
    if(isset($_POST['id'])) {

        $clearance_id = $_POST['id'];

        date_default_timezone_set('Asia/Manila');
        $date_deployed_student = date('Y-m-d H:i:s');


        require_once '../config/connection.php';
        
        $result = $clearance->deployClearanceStudent($clearance_id, $date_deployed_student);
        
        // if($result) {
        //     header('location: ../admin/clearance_management.php?success');
        // }else {
        //     header('location: ../admin/clearance_management.php?failed');
        // }
    }
?>