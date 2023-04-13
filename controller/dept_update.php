<?php  
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $dept_code = $_POST['department_code'];
        $dept_name = $_POST['department_name'];

        require_once '../config/connection.php';

        $result = $department->updateDepartment($id, $dept_code, $dept_name);

        if($result) {
            echo ' <div class="alert alert-success" id="err">Department has been updated.</div> ';
        }
    }
?>