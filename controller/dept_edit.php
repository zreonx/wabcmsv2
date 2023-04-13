<?php 
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        require_once '../config/connection.php';

        $result = $department->getDepartment($id);

        $dept_data = $result->fetch(PDO::FETCH_ASSOC);

        echo json_encode($dept_data);

    }else {
        //404
    }
?>