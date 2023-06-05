<?php 
    if(isset($_POST['submit'])) {
        require_once '../config/connection.php';

        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        

        //echo $user_id . " - ". $user_type . " - " . $old_password . "- " . $new_password . " -  " . $confirm_password; 

        $result = $user->getUserData($user_id, $user_type);

        print_r($result);
        

        if($old_password === $result['old_pass']) {
            if($new_password === $confirm_password) {

               $changPwdtatus = $user->changePassword($user_id, $new_password);
               
               if($changPwdtatus){
                    if($user_type == 'student'){
                            header("location: ../student/settings.php?change_pass=success");
                    }else if($user_type == 'signatory'){
                            header("location: ../signatory/settings.php?change_pass=success");
                    }else if ($user_type == 'admin'){
                            header("location: ../admin/settings.php?change_pass=success");
                    }
               }else {
                    if($user_type == 'student'){
                            header("location: ../student/settings.php?change_pass=failed");
                    }else if($user_type == 'signatory'){
                            header("location: ../signatory/settings.php?change_pass=failed");
                    }else if ($user_type == 'admin'){
                            header("location: ../admin/settings.php?change_pass=failed");
                    }
               }

               

            }else {

               if($user_type == 'student'){
                    header("location: ../student/settings.php?confirm_pass_match=false");
               }else if($user_type == 'signatory'){
                    header("location: ../signatory/settings.php?confirm_pass_match=false");
               }else if ($user_type == 'admin'){
                    header("location: ../admin/settings.php?confirm_pass_match=false");
               }

            }
        }else {
           if($user_type == 'student'){
                header("location: ../student/settings.php?old_pass_match=false");
           }else if($user_type == 'signatory'){
                header("location: ../signatory/settings.php?old_pass_match=false");
           }else if ($user_type == 'admin'){
                header("location: ../admin/settings.php?old_pass_match=false");
           }
            
        }
    }
?>