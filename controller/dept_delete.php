<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $department->deleteDepartment($id);

        if($result) {
            header("location: ../admin/dept_management.php?delete=success");
        }

    }
?>