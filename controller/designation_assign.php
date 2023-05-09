<?php 
    if(isset($_POST['designation_id'])){

        $designation_id = $_POST['designation_id'];
        $signatory_id = $_POST['assigned_signatory'];
        date_default_timezone_set('Asia/Manila');
        $date_assigned = date('Y-m-d H:i:s');
        

        require '../config/connection.php';

      

        $designation_info = $designation->getSpecificDesignation($designation_id);

        $workplace = $designation->getWorkplace($designation_info['category'], $designation_info['signatory_workplace']);
        $signatory_designation = $designation_info['designation'];

       //Create table name prefix and pattern
        function clearance_table_prefix($workplace, $designation, $signatory_id) {
            $raw_name = $workplace . ' ' . $designation . ' ' . $signatory_id;
            $table_name =   str_replace(' ', '_', strtolower($raw_name));
            return "sdb_" . $table_name ;
        }

        $table_name = clearance_table_prefix($workplace, $signatory_designation, $signatory_id);
        
        $checkExistBefore = $designation->checkExistingRemovedTable($table_name);

        if($checkExistBefore){
            $result = $designation->assignDesignation($designation_id, $signatory_id, $date_assigned);
            $reactivate = $designation->reactivatePreviousSignatoryTable($table_name);
        }else {
            $result = $designation->assignDesignation($designation_id, $signatory_id, $date_assigned);
        }
    }
?>