<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $request->rejectRequest($id);

        if($result) {
            header("location: ../admin/clearance_request.php?request=rejected");
        }

    }
?>