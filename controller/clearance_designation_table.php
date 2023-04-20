<?php 
    if(isset($_POST['id'])) {

        $id = $_POST['id'];
        $clearance_beneficiary = $_POST['clearance_beneficiary'];
        $clearance_type = $_POST['clearance_type'];
        $semester = $_POST['semester'];
        $academic_year = $_POST['academic_year'];

        
        require_once '../config/connection.php';

        //Fetch the signatory designation table info: name of table 

        $phead_table_name = $designation->table_for_program_head();
        $offices_table_name = $designation->table_for_offices();
        $shs_table_name = $designation->table_for_shs();
        $org_table_name = $designation->table_for_org();

        
        //$allsig_data = $designation->ad_tbname();
       // print_r($offices_table_name);
        //print_r($phead_table_name);
        //print_r($shs_table_name);

        
        if($clearance_type == "1") {

            switch($clearance_beneficiary){
                case '1': 
                    echo "all student";
                break;
                case '2': 
                    echo "all college";
                break;
                case '3': 
                    echo "all shs";
                break;

            }
             
        }else if($cleaerance_type == "2") {
            echo "transfering clearance";
        }

        //Create table name prefix and pattern
        function clearance_table_prefix($workplace, $designation, $signatory_id) {
            $raw_name = $workplace . ' ' . $designation . ' ' . $signatory_id;
            $table_name =   str_replace(' ', '_', strtolower($raw_name));
            return "sdb_" . $table_name ;
        }

        //$result = $clearance->getClearanceInfo($id);

        // $clearanceInfo = $result->fetch(PDO::FETCH_ASSOC);

        // echo json_encode($clearanceInfo);

    }else {
        //404
    }
?>