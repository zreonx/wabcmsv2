<?php 
    if(isset($_POST['submit'])){
        $strand = $_POST['strand'];
        $description = $_POST['description'];

        require '../config/connection.php';

        $result = $shs->addStrand($strand, $description);
        if($result) {
            header('location: ../admin/shs_management.php?success');
        }else {
            header('location: ../admin/shs_management.php?failed');
        }
    }
?>