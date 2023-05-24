<?php 
    if(isset($_POST['clearance_id'])) {

        $student_id = $_POST['student_id'];
        $clearance_id = $_POST['clearance_id'];

        $designation_table = $_POST['designation_table'];
    
        date_default_timezone_set('Asia/Manila');
        $date_cleared = date('Y-m-d H:i:s');

        require_once '../config/connection.php';


        echo $student_id . $clearance_id . $designation_table . $date_cleared ;


        $clearance->cleaStudentDeficiency($designation_table, $clearance_id, $student_id, $date_cleared);
        $clearance->clearDeficientStudent($designation_table, $clearance_id, $student_id, $date_cleared);
        $clearance->cleareStudentClearanceRecord($designation_table, $clearance_id, $student_id);


    }else {
        //404
    }
?>