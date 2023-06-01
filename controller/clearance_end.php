<?php
    if(isset($_POST['id'])) {

        $clearance_id = $_POST['id'];

        date_default_timezone_set('Asia/Manila');
        $date_end = date('Y-m-d H:i:s');


        require_once '../config/connection.php';
        
        $result = $clearance->endClearance($clearance_id, $date_end);
        
        // if($result) {
        //     header('location: ../admin/clearance_management.php?success');
        // }else {
        //     header('location: ../admin/clearance_management.php?failed');
        // }
    }
?>