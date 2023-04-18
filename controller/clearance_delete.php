<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $clearance->deleteClearance($id);

        if($result) {
            header("location: ../admin/clearance_management.php?delete=success");
        }

    }
?>