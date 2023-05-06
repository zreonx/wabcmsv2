<?php

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    require_once '../config/connection.php';

    $returnedRow = $clearance->checkIsClearanceDeployed($id);

    echo $returnedRow;

}