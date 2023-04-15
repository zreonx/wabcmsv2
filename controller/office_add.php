<?php 
    if(isset($_POST['submit'])){
        $office_name = $_POST['office_name'];

        require '../config/connection.php';

        $result = $office->addOffice($office_name);
        if($result) {
            header('location: ../admin/office_management.php?success');
        }else {
            header('location: ../admin/office_management.php?failed');
        }
    }
?>