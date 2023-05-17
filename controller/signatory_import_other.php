<?php 

if(isset($_POST['submit'])) {
   
    $csv = $_FILES['csvfile']['tmp_name'];
    $signatory_id = $_POST['signatory_id'];
    $clearance_id = $_POST['clearance_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $message = $_POST['message'];
    $designation_table = $_POST['designation_table'];

    $url_info_string = str_replace(" ", "", $_POST['url_info_string']);
    echo $message;

    date_default_timezone_set('Asia/Manila');
    $date_notify = date('Y-m-d H:i:s');
    
        $ext = pathinfo($_FILES['csvfile']['full_path'], PATHINFO_EXTENSION);
        if ($_FILES['csvfile']['size'] > 0) {
            
            // if( $ext !== 'csv' ) {
            //     header("location: ../admin/import_student.php?import=invalid");
            // }else {
                $file = fopen($csv, "r");
                    require_once '../config/connection.php';
                if (count(fgetcsv($file)) < 8 || count(fgetcsv($file)) > 9) {

                    header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&column=false");
                   
                } else {
                   
                    $row = 0;
                    $file = fopen($csv, "r");

                    $designationTableStudent = $clearance->getSignatoryDesignationTableStudent($designation_table, $clearance_id);

                    while (($column = fgetcsv($file, 0, ",")) !== false) {
                        $row++;
                        if ($row == 1) {
                            continue;
                        }

                        $is_duplicate = false;
                        foreach($designationTableStudent as $stud) {
                            if($stud['clearance_id'] == $clearance_id AND $stud['student_id'] == $column[0]) {
                                //Student with same clearance id and student id is being inserted | DUPLICATE
                                $is_duplicate = true;
                                break;
                            }
                        }

                        if($is_duplicate) {
                            $clearance->addStudentDeficiency($clearance_id, $designation_table, $column[0], $message, $date_notify);
                            $clearance->unclearDeficientStudent($designation_table, $clearance_id, $column[0]);
                        }

                    }   

                    // if($result == true) {   
                    //     header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&import=success");
                    // } else {
                    //     header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&error=true");
                    // }

                    header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&import=success");

                    echo "<br>";

                }
           // } 
        }else {
            header("location: ../signatory/clearance_signatory_designation.php?$url_info_string&import=empty");
        }
    }

?>
