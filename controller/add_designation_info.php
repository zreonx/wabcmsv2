<?php 
    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        require_once '../config/connection.php';


        //Program Head
        if($category == "1") {
            $workplace = $_POST['workplace'];
            $departments = $department->getDepartments();

            while($dept_row = $departments->fetch(PDO::FETCH_ASSOC)) {
                if($workplace == $dept_row['id']) {
                    //$designation_name = $dept_row['department_code'] . " Program Head";
                    $designation_name = "Program Head";
                    $designation->addDesignation($category, $designation_name, $workplace);
                    header("location: ../admin/add_designation_information.php?success");
                    break;
                }
            }


        }else {
            $workplace = $_POST['workplace'];
            $designation_name = $_POST['designation_name'];
            $designation->addDesignation($category, $designation_name, $workplace);
            header("location: ../admin/add_designation_information.php?success");
        }


        // echo $designation_name;
    }else {
        //404 not found
    }
?>