<?php

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    require_once '../config/connection.php';

    
    $submitStatus = $clearance->getSignatorySubmitStatus($id);
    
    $result = array('count' => count($submitStatus), 'submission' => $submitStatus);
    echo json_encode($result);

}