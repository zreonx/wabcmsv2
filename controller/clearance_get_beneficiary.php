<?php 
    if(isset($_POST['key'])){
        require '../config/connection.php';
        $id = $_POST['id'];
        $clearance_beneficiary = $clearance->getBeneficiary($id);

        //header('Content-Type: application/json');
        echo $clearance_beneficiary;
    }
?>