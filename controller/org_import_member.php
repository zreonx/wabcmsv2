<?php 

if(isset($_POST['submit'])) {
   
    $csv = $_FILES['csvfile']['tmp_name'];
    $org_id = $_POST['organization_id'];
    $org_code = $_POST['organization_code'];

    $url_info_string = str_replace(" ", "", $_POST['url_info_string']);
    echo $url_info_string;

    date_default_timezone_set('Asia/Manila');
    $date_approval = date('Y-m-d H:i:s');
    
        $ext = pathinfo($_FILES['csvfile']['full_path'], PATHINFO_EXTENSION);
        if ($_FILES['csvfile']['size'] > 0) {
            
            // if( $ext !== 'csv' ) {
            //     header("location: ../admin/import_student.php?import=invalid");
            // }else {
                $file = fopen($csv, "r");
                    require_once '../config/connection.php';
                if (count(fgetcsv($file)) < 8 || count(fgetcsv($file)) > 9) {

                    header("location: ../signatory/organization_management.php?$url_info_string&column=false");
                   
                } else {
                   
                    $row = 0;
                    $file = fopen($csv, "r");

                    $org_members = $organization->getOrgMember($org_code);

                    while (($column = fgetcsv($file, 0, ",")) !== false) {
                        $row++;
                        if ($row == 1) {
                            continue;
                        }

                        $is_duplicate = false;
                        foreach($org_members as $mem) {
                            if($mem['student_id'] == $column[0]) {
                                //Student with same clearance id and student id is being inserted | DUPLICATE
                                $is_duplicate = true;
                                break;
                            }
                        }

                        if(!$is_duplicate) {
                            $organization->addOrganizationMember($org_id, $org_code, $column[0]);
                        }

                    }   

                    // if($result == true) {   
                    //     header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&import=success");
                    // } else {
                    //     header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&error=true");
                    // }

                    header("location: ../signatory/organization_management.php?$url_info_string&import=success");

                    echo "<br>";

                }
           // } 
        }else {
            header("location: ../signatory/organization_management.php?$url_info_string&import=empty");
        }
    }

?>
