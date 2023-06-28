<?php 
    if(isset($_POST['submit'])) {
       $email = $_POST['email'];
       $password = $_POST['password'];
       echo $email . $password;

       require_once '../config/connection.php';

       $email_info = $user->getUserType($email);
       $user_type = $email_info['user_type'];

       $user_status = $email_info['status'];
       
       if($user_status == "active"){
            if(!$user_type) {
                $_SESSION['email'] = $email;
                    header("location: ../login.php?error=notfound");
                }else {
                    $result = $user->loginUser($user_type, $email, $password);
                if(!$result) {
                    $_SESSION['email'] = $email;
                    header("location: ../login.php?login=failed");
                }else {
                    if($user_type == 'admin') {
                        
                        $_SESSION['user_type'] = $user_type;
                        $_SESSION['user_id'] = $result['user_id'];
                        $_SESSION['user_data'] = $user->getAdminInfo($result['user_id']);

                        header("location: ../admin/index.php");
                    }else if($user_type == 'signatory') {
                        $_SESSION['user_type'] = $user_type;
                        $_SESSION['user_id'] = $result['user_id'];

                        $_SESSION['user_data'] = $user->getSignatoryInfo($result['user_id']);

                        header("location: ../signatory/clearance_management.php");
                    }else if($user_type == 'student') {
                        $_SESSION['user_type'] = $user_type;
                        $_SESSION['user_id'] = $result['user_id'];
                        
                        $_SESSION['user_data'] = $user->getStudentInfo($result['user_id']);

                        header("location: ../student/index.php");

                    }else {

                        // $_SESSION['user_type'] = $user_type;
                        // $_SESSION['user_id'] = $result['user_id'];
                        
                        // header("location: ../student/dashboard.php");
                        // echo "usertype not found";
                    }
                }

            }
        }else {
            header("location: ../login.php?user=inactive");
        }
    
    }else {
        //404 not found
    }
?>