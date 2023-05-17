<?php

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    require_once '../config/connection.php';

    $check_result = $clearance->checkIsClearanceDeployed($id);

    $returnedRow = $check_result['count'];
    
    $clearanceInfo = $clearance->getClearanceInfo($id);
    $clearanceInfo = $clearanceInfo->fetch(PDO::FETCH_ASSOC);

    $clearance_data = array('returned_row' => $returnedRow, 'clearance_info' => $clearanceInfo, 'returned_data' => $check_result['query']);

    echo json_encode($clearance_data);

}