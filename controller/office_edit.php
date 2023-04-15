<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $office->getOffice($id);

        $office_data = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($office_data);

    }else {
        //404
    }
?>