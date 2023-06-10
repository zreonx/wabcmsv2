<?php 
    if(isset($_POST['key'])){
        $clearance_id = $_POST['clearance_id'];

        require '../config/connection.php';

        $result = $dashboard->sinatoryStatus($clearance_id);
       
        echo json_encode($result);
    }
?>