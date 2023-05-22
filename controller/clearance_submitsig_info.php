<?php

if(isset($_POST['signatory_id'])) {
    $signatory_id = $_POST['signatory_id'];
    $workplace  = $_POST['workplace'];

    require_once '../config/connection.php';

    $allSignatory = $clearance->getSignatoryDesignation($signatory_id);
    
    $sig_designation = "";

    foreach($allSignatory as $sig_info) {
        $wp = $designation->getWorkplace($sig_info['category'], $sig_info['signatory_workplace']);
        if($wp == $workplace){
            $sig_designation = $sig_info['designation'];
            break;
        }
    }


    echo json_encode($sig_designation);

}