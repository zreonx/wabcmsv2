<?php 
    if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $email= $_POST['email'];

        require '../config/connection.php';

        $result = $signatory->addSignatory($firstname, $middlename, $lastname, $email);

        if($result) {
            $signatory_info = $signatory->getSignatoryInfo($email);
            $signatory_id = $signatory_info['id'];
            $user->makeUserAccount($signatory_id, "signatory", $email);
            header('location: ../admin/signatory_management.php?success');
        }else {
            header('location: ../admin/signatory_management.php?failed');
        }
    }
?>