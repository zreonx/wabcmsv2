<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        //$result = $clearance->deleteClearance($id);
        $clearanceStatus = $clearance->selectClearanceStatusRecord($id);

        if($clearanceStatus > 0) {
            $activeDesignation = $clearance->selectActiveDesignationTable();
           foreach($activeDesignation as $sig_table) {
                $result = $clearance->deleteDeployedStudentInTable($sig_table['signatory_clearance_table_name'], $id);
           }
           $result = $clearance->deleteClearance($id);
        }else {
            echo "not yet deployed";
            $result = $clearance->deleteClearance($id);
        }


        if($result) {
            header("location: ../admin/clearance_management.php?delete=success");
        }

    }
?>