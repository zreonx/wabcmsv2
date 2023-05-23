<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearanceStudent();
    $user_data = $_SESSION['user_data'];
    print_r($user_data);
    
?>
    <div class="page px-4">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Clearance (1)</h1>
        <div class="page-content rounded">
            <div class="card-grid-s">
                <?php foreach($activeClearance as $cinfo): ?>
                    
                <div class="sc-card px-3">
                    <div class="sc-header d-flex justify-content-between align-items-center">
                        <h1 class="fs-6 m-0"><?php echo $cinfo['clearance_name'] ?></h1>
                        <div class="info-btn">
                            <i class="fal fa-info-circle"></i>
                        </div>
                    </div>
                    <h1 class="f-s display-6"><em><?php echo date("M j, Y h:i A", strtotime($cinfo['date_deploy_student'])); ?></em></h1>
                   
                    <div class="text-center py-1"><strong class="py-2 f-d"><?php echo $cinfo['semester'] ?> | <?php echo $cinfo['academic_year'] ?></strong></div>
                    <div class="sc-body py-2">
                       
                        <div class="d-flex gap-2 justify-content-center mb-3">
                            <div class="sc-dash-item p-2">
                                <h1 class="display-6 f-s m-0">Signatories</h1>
                                <?php 
                                     $studentClearance = $dashboard->studentClearanceData($cinfo['clearance_id'], $user_data['student_id']);
                                ?>
                                <h1 class="f-4 m-0"><?php echo count($studentClearance); ?></h1>
                            </div>
                            <div class="sc-dash-item p-2">
                                <h1 class="display-6 f-s m-0">Cleared</h1>
                                <h1 class="f-4 m-0"><?php $cleared_student = 0;  foreach($studentClearance as $cleared){ if($cleared['clearance_status'] == '1'){ $cleared_student++; } } echo $cleared_student; ?></h1>
                            </div>
                        </div>
                    </div>

                    <div class="sc-footer d-flex justify-content-center">
                        <a href="clearance.php" class="w-100 btn btn-view btn-success rounded btnsm w-50" ><i class="fa-solid fa-folder-open me-1"></i> View Clearance</a>
                    </div>
                    
                </div>

                <?php endforeach; ?>
                
            </div>

        </div>

            <script>      
    
               
            </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>