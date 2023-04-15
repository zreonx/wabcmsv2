<?php  
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $office_name = $_POST['office_name'];

        require_once '../config/connection.php';

        $result = $office->updateOffice($id, $office_name);

        if($result) {
            echo ' <div class="alert alert-success" id="err">Office information has been updated.</div> ';
        }
    }
?>