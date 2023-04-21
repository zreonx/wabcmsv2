<?php 
    if(isset($_POST['id'])) {

        $id = $_POST['id'];
        $clearance_beneficiary = $_POST['clearance_beneficiary'];
        $clearance_type = $_POST['clearance_type'];
        $semester = $_POST['semester'];
        $academic_year = $_POST['academic_year'];

        date_default_timezone_set('Asia/Manila');
        $date_approval = date('Y-m-d H:i:s');

        
        require_once '../config/connection.php';

        //Fetch the signatory designation table info: name of table 

        // $phead_table_name = $designation->table_for_program_head();
        // $offices_table_name = $designation->table_for_offices();
        // $shs_table_name = $designation->table_for_shs();
        // $org_table_name = $designation->table_for_org();

        
        
        // print_r($allsig_data);
       // print_r($offices_table_name);
        //print_r($phead_table_name);
        //print_r($shs_table_name);


        //Select all students

        $allStudent = $clearance->selectAllStudents();
        $allsig_data = $designation->ad_tbname();

        
        
        if($clearance_type == "1") {

            switch($clearance_beneficiary){
                case '1': 
                    foreach($allsig_data as $sig_des) {

                        //Get Active Signatories
                        $activeSig = $designation->designationTableRecord();
                        foreach($activeSig as $sig) {

                            //Course -> College / Departments -> Signatories / Strand ->SHS
                            if($sig_des['signatory_workplace_name'] == $sig['signatory_workplace_name']) {
                                $tb_name = $sig['signatory_clearance_table_name'];
                                foreach($allStudent as $stud){
                                    if($sig_des['signatory_workplace_name'] == $stud['program_course']){
                                        //function of inserting student 
                                        $clearance->insertStudentToTable($tb_name, $id, $semester, $academic_year, $stud['student_id'], $date_approval);
                                    }
                                }
                            }

                        }

                         //offices
                         $offices = $office->getAllOffice();
                         foreach($offices as $ofc) {
                             if($sig_des['signatory_workplace_name'] == $ofc['office_name']) {

                                 //Get Active Signatories
                                foreach($activeSig as $sig) {

                                    if($sig_des['signatory_workplace_name'] == $sig['signatory_workplace_name']) {
                                        $tb_name = $sig['signatory_clearance_table_name'];

                                        if($ofc['office_name'] == "SHS Principal Office"){
                                            //insert SHS students
                                            foreach($allStudent as $stud){
                                                //check if the student is SHS
                                                $shs_strand = array("ABM","STEM");
                                                if(in_array($stud['program_course'], $shs_strand)){
                                                    $clearance->insertStudentToTable($tb_name, $id, $semester, $academic_year, $stud['student_id'], $date_approval);
                                                }
                                            }
                                        }else {
                                            foreach($allStudent as $stud){
                                                //check if the student is SHS
                                                $clearance->insertStudentToTable($tb_name, $id, $semester, $academic_year, $stud['student_id'], $date_approval);
                                            }
                                        }
                                        
                                    }

                                }
                             }           
                         }

                    }
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

       

        //$result = $clearance->getClearanceInfo($id);

        // $clearanceInfo = $result->fetch(PDO::FETCH_ASSOC);

        // echo json_encode($clearanceInfo);

    }else {
        //404
    }
?>