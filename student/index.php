<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearanceStudent();
    $previousClearance = $clearance->getPreviousClearance();
    
    $user_data = $_SESSION['user_data'];
    
?>
    <div class="page px-4">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title fs-6 display-6 mb-0">Clearance</h1>

            <div class="dropdown">
                <div class="setoptions" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </div>
                <ul class="dropdown-menu">
                    <li><button id="showArch" class="dropdown-item" href="#">Show Archive</button></li>
                    <li><button id="hideArch" class="dropdown-item" href="#">Hide Archive</button></li>
                </ul>
            </div>
            
        </div>
        <iv class="page-content rounded x-border">
            <div id="current-data">
            <?php if($user_data['status'] == 'imported'): ?>
                
            <?php if(!empty($activeClearance)): ?>
            <div class="card-grid-s x-border" >
                <?php foreach($activeClearance as $cinfo): ?>

                    <?php 
                        $myClearance = $clearance->getPersonalClearance($cinfo['clearance_id'], $user_data['student_id']); 
                        if(!empty($myClearance)):
                    ?>
                    
                <div class="sc-card">
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
                        <a href="clearance.php?clearance_id=<?php echo $cinfo['clearance_id']?>" class="w-100 btn btn-view btn-success rounded btnsm w-50" ><i class="fa-solid fa-folder-open me-1"></i> View Clearance</a>
                    </div>
                    
                </div>
                
                <?php endif; ?>
                <?php endforeach; ?>
                
            </div>
            <?php else: ?>
                <h1 class="display-6 fs-5 text-center m-0">There is no active clearance to show</h1>
                <div class="d-flex justify-content-center h-50 mt-4">
                    <img class="img-fluid opacity-50" src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1233.jpg?w=740&t=st=1687967042~exp=1687967642~hmac=2085af3ddc6ff462d49b7037046f95e359adfa45ae402b49bbf4c210e6bb84be" alt="">
                </div>
            <?php endif; ?>
               
            <?php else: ?>

                <h1 class="display-6 fs-5 text-center m-0">You're already graduated you can only view your previous clearance.</h1>
                <div class="d-flex justify-content-center h-50 mt-4">
                    <img class="img-fluid opacity-50" src="https://img.freepik.com/free-vector/empty-concept-illustration_114360-1233.jpg?w=740&t=st=1687967042~exp=1687967642~hmac=2085af3ddc6ff462d49b7037046f95e359adfa45ae402b49bbf4c210e6bb84be" alt="">
                </div>
                    
            <?php endif; ?>
            </div>

        
        
            <div id="archive">
                <hr class="bg-light mt-4 mb-3">
                <h1 class="page-title fs-6 display-6 mt-3 mb-3">Previous Clearance</h1>

                <div class="card-grid-s">
                    <?php foreach($previousClearance as $cinfo): ?>
                   
                        <?php 
                            $myClearance = $clearance->getPersonalClearance($cinfo['clearance_id'], $user_data['student_id']); 
                           if(!empty($myClearance)):
                        ?>
                        
                    <div class="sc-card arch-card px-3">
                        <div class="sc-header d-flex justify-content-between align-items-center">
                            <h1 class="fs-6 m-0"><?php echo $cinfo['clearance_name'] ?></h1>
                            <div class="info-btn">
                                <i class="fal fa-info-circle"></i>
                            </div>
                        </div>
                        <h1 class="f-s display-6"><em><?php echo date("M j, Y h:i A", strtotime($cinfo['date_deploy_student'])); ?></em></h1>
                    
                        <div class="text-center py-1"><strong class="py-2 f-d"><?php echo $cinfo['semester'] ?> | <?php echo $cinfo['academic_year'] ?></strong></div>
                        <div class="sc-body py-2">
                        
                        </div>

                        <div class="sc-footer d-flex justify-content-center">
                            <a href="clearance.php?clearance_id=<?php echo $cinfo['clearance_id']?>" class="w-100 btn btn-view btn-secondary rounded btnsm w-50" ><i class="fa-solid fa-folder-open me-1"></i> View Clearance</a>
                        </div>
                        
                    </div>
                    
                    <?php endif; ?>
                    <?php endforeach; ?>
                            
                    
                </div>
            </div>


            <script>
                $(document).ready(function(){
                    $('#archive').hide();
                    $('#showArch').click(function(){
                        $('#archive').show();
                        //$('#current-data').hide();
                        
                    })

                    $('#hideArch').click(function(){
                        $('#archive').hide();
                        //$('#current-data').show();
                    })
                });
            </script>


        </div>

            <script>      
    
               
            </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>