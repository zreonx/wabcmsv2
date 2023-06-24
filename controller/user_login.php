<?php 
    if(isset($_POST['submit'])) {
       $email = $_POST['email'];
       $password = $_POST['password'];
       echo $email . $password;

       require_once '../config/connection.php';

       $user_type = $user->getUserType($email);

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
        //404 not found
    }
?>