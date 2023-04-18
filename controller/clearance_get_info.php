<?php 
    if(isset($_POST['id'])) {

        $id = $_POST['id'];

        require_once '../config/connection.php';

        $result = $clearance->getClearanceInfo($id);

        $clearanceInfo = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($clearanceInfo);

    }else {
        //404
    }
?>