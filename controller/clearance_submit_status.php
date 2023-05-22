<?php

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    require_once '../config/connection.php';

    
    $submitStatus = $clearance->getSignatorySubmitStatus($id);
    

    echo json_encode($submitStatus);

}