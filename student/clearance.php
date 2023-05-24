<?php 
    require_once '../includes/main_header.php'; 
    $clearance_id = $_GET['clearance_id'];

    $cl_info = $clearance->getActiveClearanceById($clearance_id);
    $user_data = $_SESSION['user_data'];

    $midinit = strtoupper(substr($user_data['middle_name'], 0, 1)) . ". ";
    $midname = ($user_data['middle_name'] == '') ? ' ' : $midinit;

    $allSignatory = $clearance->allActiveSignatoryTable();
?>
    <div class="page x-border">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6"></h1>
        <div class="page-content rounded ">
            <div class="cl-page mx-auto default-border">
                <div class="d-flex flex-column pb-3">
                    <h1 class="fs-6 text-center">CLEARANCE</h1>
                    <h1 class="f-d display-6 ms-auto"><?php echo date("M j, Y"); ?></h1>
                    <div class="t-justify">This is to certify that <strong><?php echo $user_data['first_name'] . " " . $midname . $user_data['last_name'] ; ?></strong>, with student No. <strong><?php echo $user_data['student_id']; ?></strong>, is a student of the City College of Calapan and he/she is cleared from all of his/her obligations this <?php echo $cl_info['semester']; ?>, Academic Year  <?php echo $cl_info['academic_year']; ?>. </div>
                </div>

                <div class="cl-grid gap-4 text-center mb-5 berow">
                    <div class="d-flex flex-column justify-content-center mt-2">
                        <?php 
                           foreach($allSignatory as $sigTable){
                                if(preg_match("/librarian/", $sigTable['signatory_clearance_table_name'])){
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" id="view-def-btn"  data-bs-toggle="tooltip" title="View Deficiency"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div>';
                                    }
                                }
                                
                           }
                        ?>
                        <hr class="my-2 c-hr mx-auto"/>
                        <h1 class="f-d m-0">Name</h1>
                        <span class="fs-d">College Librarian</span>
                    </div>
                    <div class="d-flex flex-column justify-content-center mt-2">
                        <?php 
                           foreach($allSignatory as $sigTable){
                                if(preg_match("/guidance_office/", $sigTable['signatory_clearance_table_name'])){
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" id="view-def-btn"  data-bs-toggle="tooltip" title="View Deficiency"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div>';
                                    }
                                }
                           }
                        ?>
                        <div><hr class="my-2 c-hr mx-auto"/></div>
                        <h1 class="f-d m-0">Name</h1>
                        <span class="fs-d">Guidance Office</span>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                    <div class="d-flex flex-column justify-content-center">
                        <?php 
                           foreach($allSignatory as $sigTable){
                                $search = '/' . strtolower($user_data['program_course']) . '_program_head/' ;
                                if(preg_match($search , $sigTable['signatory_clearance_table_name'])){
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" id="view-def-btn"  data-bs-toggle="tooltip" title="View Deficiency"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div>';
                                    }
                                }    
                           }
                        ?>
                        <hr class="my-2 c-hr mx-auto"/>
                        <h1 class="f-d m-0">Name</h1>
                        <span class="fs-d">Program Head</span>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                    <div class="d-flex flex-column justify-content-center">
                        <hr class="my-2 c-hr mx-auto"/>
                        <h1 class="f-d m-0">Name</h1>
                        <span class="fs-d">Director, Student Affair and Services</span>
                    </div>
                </div>

            </div>
            

        </div>

            <script>      
    
               
            </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>