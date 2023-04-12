<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $organization->getOrganization($id);

        $org_data = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($org_data);

    }else {
        //404
    }
?>