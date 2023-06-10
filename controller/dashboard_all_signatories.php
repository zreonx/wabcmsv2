<?php 
    if(isset($_POST['key'])){

        require '../config/connection.php';

        $result = $allSignatories = $dashboard->getAllDesignation();
       
        echo $result;
    }
?>