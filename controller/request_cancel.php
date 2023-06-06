<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $request->cancelRequest($id);

        if($result) {
            header("location: ../student/request_clearance.php?request=cancelled");
        }

    }
?>