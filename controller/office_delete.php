<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $office->deleteOffice($id);

        if($result) {
            header("location: ../admin/office_management.php?delete=success");
        }

    }
?>