<?php
    if(isset($_POST['key'])) {
        $organization_code =  $_POST['organization_code'];
        $organization_name =  $_POST['organization_name'];
        $organization_dept = $_POST['linked_department'];

        require_once '../config/connection.php';
        
        $organization->addOrganization($organization_code, $organization_name, $organization_dept);

        if($organization) {
            echo ' <div class="alert alert-success" id="err">Oranization has been added.</div> ';
        }
    }
?>