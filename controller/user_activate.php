<?php  
    if(isset($_POST['id'])) {

        $id = $_POST['id'];

        require_once '../config/connection.php';

        $result = $user->activateAccount($id);

    }
?>