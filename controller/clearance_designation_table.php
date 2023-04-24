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
            if($designation->checkTableNameExist($table_name)){
                //table exist, do nothing
            }else {
                 if($designation->addSignatoryDesignationRecord($sd_info['signatory_id'], $sd_info['signatory_workplace_name'], $table_name)) {
                     $designation->createSignatoryDesignationClearance($table_name);
                 }else{
                    echo 'failed to insert to designation table';
                 }
            }
        }
        
        $response = array(
            'success' => true,
            'message' => '<div class="alert alert-success" id="err">Signatory Assigned designations has been activated. Clearance management for signatories can now be deploy.</div>'
        );

        echo json_encode($response);
        
    }else {
        //404
    }
?>