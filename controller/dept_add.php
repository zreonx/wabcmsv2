<?php 
    if(isset($_POST['submit'])){
        $department_code = $_POST['department_code'];
        $department_name = $_POST['department_name'];


        require '../config/connection.php';

        $result = $department->addDepartment($department_code, $department_name);
        if($result) {
            header('location: ../admin/add_department.php?success');
        }else {
            header('location: ../admin/add_department.php?failed');
        }
    }
?>