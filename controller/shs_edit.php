<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $shs->getStrand($id);

        $shs_data = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($shs_data);

    }else {
        //404
    }
?>