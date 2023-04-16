<?php  
    if(isset($_POST['id'])) {

        $id = $_POST['id'];
        $firstname = $_POST['first_name'];
        $middlename = $_POST['middle_name'];
        $lastname = $_POST['last_name'];
        $email = $_POST['email'];

        require_once '../config/connection.php';

        $result = $signatory->updateSignatory($id, $firstname, $middlename, $lastname, $email);

        if($result) {
            echo ' <div class="alert alert-success" id="err">Signatory information has been updated.</div> ';
        }
    }
?>