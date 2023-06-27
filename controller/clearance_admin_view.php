<?php
    if(isset($_POST['student_id'])) {

        $student_id = $_POST['student_id'];
        $clearance_id = $_POST['clearance_id'];

        

        require_once '../config/connection.php';

    }
    
?>

<iframe src="../admin/clearance_download_template.php?clearance_id=<?php echo $clearance_id ?>&student_id=<?php echo $student_id ?>" id="clearanceFrame" frameborder="0" style="height: 100%; border:0; width:100%;"></iframe>
