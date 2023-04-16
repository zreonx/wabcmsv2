<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $signatory->getSignatory($id);

        $sign_data = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($sign_data);

    }else {
        //404
    }
?>