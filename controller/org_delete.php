<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $organization->deleteOrg($id);

        if($result) {
            header("location: ../admin/add_organization.php?delete=success");
        }

    }
?>