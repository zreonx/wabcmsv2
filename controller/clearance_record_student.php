<?php

if(isset($_POST['id'])) {
    $clearance_id = $_POST['id'];

    require_once '../config/connection.php';

    //get all enrolled student
    $allEnrolledStudent = $clearance->allStudentTakingClearance();

    //get all active signatories
    $allActiveSignatories = $clearance->getActiveSignatoryDesignation();

    //for every signatories
    foreach($allActiveSignatories as $sig){
        //get their signatorytable
        $sigTableData = $clearance->activeSignatoryTableData($sig['signatory_clearance_table_name'], $clearance_id);
        //every table get the student inside the signatory table
       foreach($sigTableData as $sigData) {
            //if the student is inside the table-> check student clearance status -> add them to student_clearance_record
            foreach($allEnrolledStudent as $stud){
                if($sigData['student_id'] == $stud['student_id']){

                    $studClearanceData = $clearance->getStudentClearanceStatus($sig['signatory_clearance_table_name'], $clearance_id, $stud['student_id']);
                    $clearance->insertStudentClearanceRecord($clearance_id, $sig['signatory_id'], $sig['signatory_clearance_table_name'], $stud['student_id'], $studClearanceData['student_clearance_status']);
                
                }
            }
       }

       
    }
    // $submitStatus = $clearance->getSignatorySubmitStatus($id);
    
    // $result = array('count' => count($submitStatus), 'submission' => $submitStatus);
    // echo json_encode($result);

}