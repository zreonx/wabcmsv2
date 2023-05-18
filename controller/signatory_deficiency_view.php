<?php 
    if(isset($_POST['clearance_id'])) {

        $student_id = $_POST['student_id'];
        $clearance_id = $_POST['clearance_id'];

        $designation_table = $_POST['designation_table'];
    
        date_default_timezone_set('Asia/Manila');
        $date_cleared = date('Y-m-d H:i:s');

        require_once '../config/connection.php';


        $allDeficiency = $clearance->getStudentDeficiency($designation_table, $clearance_id, $student_id);
        
    ?> 
    <?php if(count($allDeficiency) > 0): ?>
    <div class="position-relative">
        <h1 class="fs-6">Deficiencies</h1><span class="badge-msg" id="nod"><?php echo count($allDeficiency); ?></span>
    </div>
    <?php foreach($allDeficiency as $stud_def): ?>
        <div class="bg-successaccent p-2 mb-2 bg-greenlight rounded">
            <h1 class="f-s display-6">Sent: <em><?php echo date_format(date_create($stud_def['date_notify']), 'M d, Y \a\t h:i a') ?></em></h1>
            <div class="f-ms display-6 px-2 pb-2">
               <?php echo $stud_def['message'] ?>
            </div>
        </div>
    <?php endforeach; ?>
        
    <?php else: ?>

        <div class="bg-successaccent p-2 mb-2 bg-greenlight rounded">
            <div class="f-ms display-6 px-2 py-2 text-center">
               No message deficiency found.
            </div>
        </div>

    <?php endif; ?>
    <?php }else {
        //404
    }
?>