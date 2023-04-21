<?php 
    if(isset($_POST['key'])) {

        require_once '../config/connection.php';

        //Fetch the signatory designation table info: name of table 

        $allsig_data = $designation->ad_tbname();

        //Create table name prefix and pattern
        function clearance_table_prefix($workplace, $designation, $signatory_id) {
            $raw_name = $workplace . ' ' . $designation . ' ' . $signatory_id;
            $table_name =   str_replace(' ', '_', strtolower($raw_name));
            return "sdb_" . $table_name ;
        }

        foreach($allsig_data as $sd_info) {
            $table_name = clearance_table_prefix($sd_info['signatory_workplace_name'], $sd_info['signatory_designation'], $sd_info['signatory_id']);
            $designation->deleteDesignationTable($table_name);
        }
        $response = array(
            'success' => true,
            'message' => '<div class="alert alert-success" id="err">Designation Table has been deleted for development purpose</div>'
        );
        
        echo json_encode($response);
        


        //$result = $clearance->getClearanceInfo($id);

        // $clearanceInfo = $result->fetch(PDO::FETCH_ASSOC);

        // echo json_encode($clearanceInfo);

    }else {
        //404
    }
?>