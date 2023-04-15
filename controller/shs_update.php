<?php  
    if(isset($_POST['id'])) {

        $id = $_POST['id'];
        $strand = $_POST['strand'];
        $description = $_POST['description'];

        require_once '../config/connection.php';

        $result = $shs->updateStrand($id, $strand, $description);

        if($result) {
            echo ' <div class="alert alert-success" id="err">Strand has been updated.</div> ';
        }
    }
?>