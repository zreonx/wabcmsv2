<?php 
    if(isset($_POST['clearance_id'])) {

      
        $clearance_id = $_POST['clearance_id'];
        $designation_table = $_POST['designation_table'];
        $cd_id = $_POST['cd_id'];
    
        date_default_timezone_set('Asia/Manila');
        $date_submit = date('Y-m-d H:i:s');

        require_once '../config/connection.php';


        $clearance->submitDeficiency($designation_table, $cd_id, $date_submit);
        

    }else {
        //404
    }
?>