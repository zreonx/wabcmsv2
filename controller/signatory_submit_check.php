<?php 
    if(isset($_POST['clearance_id'])) {

        $clearance_id = $_POST['clearance_id'];
        $designation_table = $_POST['designation_table'];

        date_default_timezone_set('Asia/Manila');
        $date_notify = date('Y-m-d H:i:s');

        require_once '../config/connection.php';


        $sumitDeficiencyStatus = $clearance->checkDeficiencySubmitStatus($clearance_id, $designation_table);

        echo json_encode($sumitDeficiencyStatus);


    }else {
        //404
    }
?>