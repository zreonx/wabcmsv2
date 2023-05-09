<?php 
    if(isset($_GET['designation_id'])){

        $designation_id = $_GET['designation_id'];
        
        require '../config/connection.php';

       
        $designation_info = $designation->getDesignationInfo($designation_id);


        $workplace = $designation->getWorkplace($designation_info['category'], $designation_info['signatory_workplace']);
        $signatory_designation = $designation_info['designation'];
        $signatory_id = $designation_info['signatory_id'];

        //Create table name prefix and pattern
        function clearance_table_prefix($workplace, $designation, $signatory_id) {
            $raw_name = $workplace . ' ' . $designation . ' ' . $signatory_id;
            $table_name =   str_replace(' ', '_', strtolower($raw_name));
            return "sdb_" . $table_name ;
        }

        $signatory_table = clearance_table_prefix($workplace, $signatory_designation, $signatory_id);

        $removeAssignDesignationResult = $designation->removeSignatoryDesignation($designation_id);
       
        if($removeAssignDesignationResult) {
          $designation->removeDesignationTable($signatory_id, $signatory_table);
          header("location: ../admin/add_designation_information.php?signatory-remove=success");
        }else {
          header("location: ../admin/add_designation_information.php?signatory-remove=failed");
        }
    }
?>