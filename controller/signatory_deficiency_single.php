<?php 
    if(isset($_POST['signatory_id'])) {

        $student_id = $_POST['student_id'];
        $signatory_id = $_POST['signatory_id'];
        $clearance_id = $_POST['clearance_id'];
        $semester = $_POST['semester'];
        $academic_year = $_POST['academic_year'];
        $message = $_POST['message'];
        $designation_table = $_POST['designation_table'];
    
        $url_info_string = str_replace(" ", "", $_POST['url_info_string']);
        echo $student_id;
    
        date_default_timezone_set('Asia/Manila');
        $date_notify = date('Y-m-d H:i:s');

        require_once '../config/connection.php';


        $clearance->addStudentDeficiency($clearance_id, $designation_table, $student_id, $message, $date_notify);
        $clearance->unclearDeficientStudent($designation_table, $clearance_id, $student_id);

        header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&defiency=added");

    }else {
        //404
    }
?>