<?php 
    if(isset($_POST['designation_id'])){

        $designation_id = $_POST['designation_id'];
        $signatory_id = $_POST['assigned_signatory'];
        date_default_timezone_set('Asia/Manila');
        $date_assigned = date('Y-m-d H:i:s');
        

        require '../config/connection.php';

        $result = $designation->assignDesignation($designation_id, $signatory_id, $date_assigned);

        if($result) {
           echo '<div class="alert alert-success" id="err">Designation has been assigned.</div>';
        }else {
           echo '<div class="alert alert-danger" id="err">Failed assigning designation.</div>';
        }
    }
?>