<?php 

if(isset($_POST['submit'])) {
   
    $csv = $_FILES['csvfile']['tmp_name'];
    
        $ext = pathinfo($_FILES['csvfile']['full_path'], PATHINFO_EXTENSION);
        if ($_FILES['csvfile']['size'] > 0) {
            
            // if( $ext !== 'csv' ) {
            //     header("location: ../admin/import_student.php?import=invalid");
            // }else {
                $file = fopen($csv, "r");
                    require_once '../config/connection.php';
                if (count(fgetcsv($file)) < 9 || count(fgetcsv($file)) > 9) {

                    header("location: ../admin/student_management.php?column=false");
                   
                } else {
                   
                    $row = 0;
                    $file = fopen($csv, "r");

                    $current_users = $user->getAllUser();

                    while (($column = fgetcsv($file, 0, ",")) !== false) {
                        $row++;
                        if ($row == 1) {
                            continue;
                        }

                        $result = $student->importStudent(['student_id' => $column[0], 'first_name' => $column[1], 'middle_name' => $column[2], 'last_name' => $column[3], 'contact_number' => $column[4], 'email' => $column[5], 'program_course' => $column[6], 'academic_level' => $column[7], 'year_level' => $column[8]]);
                        
                        $user_exists = false;

                        foreach($current_users as $user_data){
                            if($column[0] == $user_data['user_id']) {
                                $student->graduateStudent($column[0]);
                                $user_exists = true;
                                break;
                            }
                        }
                    
                        // if (!$user_exists) {
                        //     $user->makeUserAccount($column[0], "student", $column[5]);
                        // }
                    }   

                    if($result == true) {   
                        header("location: ../admin/student_management.php?importgraduate=success");
                    } else {
                        header("location: ../admin/student_management.php?error=true");
                    }

                    echo "<br>";

                }
           // } 
        }else {
            header("location: ../admin/student_management.php?import=empty");
        }
    }

?>
