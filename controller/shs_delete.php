<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $shs->deleteSHS($id);

        if($result) {
            header("location: ../admin/shs_management.php?delete=success");
        }

    }
?>