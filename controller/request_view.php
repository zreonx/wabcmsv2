<?php 
    if(isset($_POST['request_id'])) {

        $student_id = $_POST['student_id'];

        $request_id = $_POST['request_id'];

        require_once '../config/connection.php';


        $requestInfo = $request->getRequestInfo($request_id, $student_id);


?>

<div class="rounded">
    <div>
        <div class="d-flex justify-content-between align-items-center pb-2">
            <h1 class="fs-6 display-6"><?php echo $requestInfo['clearance_name'] ?></h1>
            <div class="badge <?php if($requestInfo['request_status'] == 'pending'){ echo 'bg-primary'; }elseif($requestInfo['request_status'] == 'rejected'){echo 'bg-danger';}elseif($requestInfo['request_status'] == 'issued'){echo 'bg-success'; }; ?>"><span><?php echo ucfirst($requestInfo['request_status']); ?></span></div>
        </div>
        <div class="bg-white shadow-s p-3 f-d rounded mt-1"><?php echo $requestInfo['reason_of_request'] ?></div>
        <div class="d-flex justify-content-end">
            <div class="f-s mt-3">Date Requested: <em><?php echo date_format(date_create($requestInfo['date_requested']), 'M d, Y \a\t h:i a') ?></em></div>
        </div>
    </div>
<table class="table table-borderless"></table>
</div>

       


<?php
    }else {
        //404
    }
?>