<?php  
    if(isset($_POST['id'])) {
        $org_id = $_POST['id'];
        $org_name = $_POST['organization_name'];
        $org_code = $_POST['organization_code'];
        $linked_department = $_POST['linked_department'];

        echo $org_code;

        require_once '../config/connection.php';

        $result = $organization->updateOrganization($org_id, $org_code, $org_name, $linked_department);

        if($result) {
            echo ' <div class="alert alert-success" id="err">Oranization has been updated.</div> ';
        }
    }
?>