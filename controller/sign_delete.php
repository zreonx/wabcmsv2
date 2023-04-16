<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $signatory->deleteSignatory($id);

        if($result) {
            header("location: ../admin/signatory_management.php?delete=success");
        }

    }
?>