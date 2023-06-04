<?php 
    require_once '../includes/main_header.php'; 
    $clearance_id = $_GET['clearance_id'];

    $cl_info = $clearance->getActiveClearanceById($clearance_id);
    $user_data = $_SESSION['user_data'];

    $midinit = strtoupper(substr($user_data['middle_name'], 0, 1)) . ". ";

    $midname = ($user_data['middle_name'] == '') ? ' ' : $midinit;

    $allSignatory = $clearance->allActiveSignatoryTable();

    $allSignatoryOrg = $clearance->allActiveSignatoryTableOrg();

?>
    <div class="page x-border">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
      <div class="d-flex justify-content-between mb-2">
        <h1 class="page-title fs-5 display-6"></h1>
        <button class="btn btn-success rounded dl-btn" id="downloadBtn"><i class="fad fa-cloud-download me-1"></i> Download</button>
        <!-- <a href="../controller/student_download_pdf.php?clearance_id=26" class="btn btn-success rounded dl-btn"><i class="fad fa-cloud-download me-1"></i> Download</a> -->
      </div>
        <div class="page-content rounded ">
            <?php if($user_data['academic_level'] == 'College'): ?>
            <div class="college"> 
                <div class="cl-page mx-auto default-border shadow-sm">

                
                    <div class="d-flex flex-column pb-3">
                        <div class="w-100 clearance-header gap-5 d-flex align-items-center mb-3 border-bottom pb-3">
                            <div class="ccclogo">
                                <img src="../images/ccc_logo.webp" alt="ccclogo" style="height:120px;">
                            </div> 
                            <div class="text-center flex-grow-1">
                                <h1 class="m-0 fs-5">CITY COLLEGE OF CALAPAN</h1>
                                <h1 class="m-0 f-s">(Dalubhasaan ng Lungsod ng Calapan)</h1>
                                <h1 class="m-0 f-s"><em>Brgy. Guinobatan Calapan City, Oriental Mindoro</em></h1>
                                <h1 class="m-0 f-s"><em>Tel No. (02) 288-7013</em></h1>
                            </div> 
                        </div>
                        <h1 class="fs-6 text-center">CLEARANCE</h1>
                        <h1 class="f-d ms-auto"><?php echo date("M j, Y"); ?></h1>
                        <div class="t-justify">This is to certify that <strong><?php echo $user_data['first_name'] . " " . $midname . $user_data['last_name'] ; ?></strong>, with student No. <strong><?php echo $user_data['student_id']; ?></strong>, is a student of the City College of Calapan and he/she is cleared from all of his/her obligations this <?php echo $cl_info['semester']; ?>, Academic Year  <?php echo $cl_info['academic_year']; ?>. </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 text-center mb-5 berow">
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                            foreach($allSignatory as $sigTable){
                                    if(preg_match("/librarian/", $sigTable['signatory_clearance_table_name'])){
                                        $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($cleared_info['student_clearance_status'] == '1'){
                                            echo '<div><i class="far fs-4 fa-check"></i></div>';
                                        }else{
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }
                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        
                                        echo '
                                            <hr class="my-2 c-hr mx-auto"/>
                                            <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name']. ' ' . $sig_info['last_name'].'</h1>
                                        ';
                                    }
                                    
                            }
                            ?>
                            <span class="fs-d">College Librarian</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                             $guidanceexist = false;
                            foreach($allSignatory as $sigTable){
                                $guidanceexist = true;
                                if(preg_match("/guidance_office/", $sigTable['signatory_clearance_table_name'])){
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                    }

                                    $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                    echo '
                                            <hr class="my-2 c-hr mx-auto"/>
                                            <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                        ';
                                }
                            }
                            if(!$guidanceexist){
                                echo "Guidance does not set yet.";
                            }
                            
                            ?>
                            <span class="fs-d">Guidance Office</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php 
                            $phexist = false;
                            foreach($allSignatory as $sigTable){
                                
                                    $search = '/' . strtolower($user_data['program_course']) . '_program_head/' ;
                                    if(preg_match($search , $sigTable['signatory_clearance_table_name'])){
                                        $phexist = true;
                                        $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($cleared_info['student_clearance_status'] == '1'){
                                            echo '<div><i class="far fs-4 fa-check"></i></div>';
                                        }else{
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }
                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                <span class="fs-d">Program Head</span>
                                            ';
                                        
                                    }   
                                    
                            }

                            if(!$phexist){
                                echo "Your Program Head does not set yet.";
                            }
                           
                           
                            ?>
                            
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                        <?php 
                            $sasexist = false;
                            foreach($allSignatory as $sigTable){
                                    if(preg_match("/sas/", $sigTable['signatory_clearance_table_name'])){
                                        $sasexist = true;
                                        $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($cleared_info['student_clearance_status'] == '1'){
                                            echo '<div><i class="far fs-4 fa-check"></i></div>';
                                        }else{
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }

                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                <span class="fs-d">Director, Student Affair and Services</span>
                                                ';
                                    }
                                
                            }
                            if(!$sasexist){
                                echo "Sas does not set yet.";
                            }
                            ?>
                           
                        </div>
                    </div>

                </div>

                <div class="cl-page mx-auto default-border mt-5 shadow-sm">
                    <div class="d-flex flex-column pb-3">
                        <h1 class="fs-6 text-center m-0">CITY COLLEGE OF CALAPAN</h1>
                        <h1 class="fs-6 text-center">STUDENT AFFAIRS AND SERVICES CLEARANCE</h1>
                    </div>

                    <div class="cl-grid gap-4 text-center mb-5 berow">
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                                foreach($allSignatoryOrg as $sigOrg){
                                    $yourOrg = false;
                                    $course_id = $clearance->getStudentCourseId($user_data['program_course']);
                                    $search = strtolower($user_data['program_course']) . "_president";
                                    if($course_id != $sigOrg['linked_department']){
                                        $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($checkIfRegistered > 0) {
                                            $yourOrg = true;
                                            if(preg_match("/president/", $sigOrg['signatory_clearance_table_name']) AND !preg_match("/sp/", $sigOrg['signatory_clearance_table_name'])){
                                                $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                                if(!empty($cleared_info)){
                                                    if($cleared_info['student_clearance_status'] == '1'){
                                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                    }else{
                                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                    }
                                                    $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                    echo '
                                                    <hr class="my-2 c-hr mx-auto"/>
                                                    <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                    ';
                                                    echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'President</span>';
                                                }
                                            }
                                            break;
                                        }
                                    }
                                }
                                if(!$yourOrg){
                                    echo "You does not have other organization";
                                }
                            
                            ?>
                            
                        </div>
                        <div class="d-flex flex-column justify-content-center mt-2">
                        <?php 
                                foreach($allSignatoryOrg as $sigOrg){
                                    $yourOrgAd = false;
                                    if(preg_match("/adviser/", $sigOrg['signatory_clearance_table_name'])){
                                        if($course_id != $sigOrg['linked_department'] AND !preg_match("/sp/", $sigOrg['signatory_clearance_table_name'])){
                                            if($checkIfRegistered > 0) {
                                                $yourOrgAd = true;
                                                if(preg_match("/adviser/", $sigOrg['signatory_clearance_table_name']) AND !preg_match("/sp/", $sigOrg['signatory_clearance_table_name'])){
                                                    $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                                    if(!empty($cleared_info)){
                                                        if($cleared_info['student_clearance_status'] == '1'){
                                                            echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                        }else{
                                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                        }
                                                        $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                        echo '
                                                        <hr class="my-2 c-hr mx-auto"/>
                                                        <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                        ';
                                                        echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'President</span>';
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                    }
                                    
                                }   
                                if(!$yourOrgAd){
                                    echo "You does not have other organization";
                                }
                               
                            ?>
                            
                        </div>

                        
                        

                        
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php 
                                $yourOrgDeptPres = false;
                                foreach($allSignatoryOrg as $sigOrg){
                                    $course_id = $clearance->getStudentCourseId($user_data['program_course']);

                                    $search = strtolower($user_data['program_course']) . "_president";

                                    if($course_id == $sigOrg['linked_department']){

                                        $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($checkIfRegistered > 0) {
                                            if(preg_match("/president/", $sigOrg['signatory_clearance_table_name'])){
                                                $yourOrgDeptPres = true;
                                                $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                                if(!empty($cleared_info)){
                                                    if($cleared_info['student_clearance_status'] == '1'){
                                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                    }else{
                                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                    }
                                                    $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                    echo '
                                                    <hr class="my-2 c-hr mx-auto"/>
                                                    <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                    ';
                                                    echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'President</span>';
                                                }
                                            }

                                        }
                                    }
                                }
                                if(!$yourOrgDeptPres){
                                    echo "Youre not registered to your departmental organization";
                                }
                            
                            ?>
                            
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php 
                                $yourOrgDeptAd = false;
                                foreach($allSignatoryOrg as $sigOrg){
                                    $course_id = $clearance->getStudentCourseId($user_data['program_course']);

                                    $search = strtolower($user_data['program_course']) . "_president";

                                    if($course_id == $sigOrg['linked_department']){

                                        $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($checkIfRegistered > 0) {
                                            if(preg_match("/adviser/", $sigOrg['signatory_clearance_table_name'])){
                                                $yourOrgDeptAd = true;
                                                $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                                if(!empty($cleared_info)){
                                                    if($cleared_info['student_clearance_status'] == '1'){
                                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                    }else{
                                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                    }
                                                    $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                    echo '
                                                    <hr class="my-2 c-hr mx-auto"/>
                                                    <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                    ';
                                                    echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'Adviser</span>';
                                                }
                                            }

                                        }
                                    }
                                }
                                if(!$yourOrgDeptAd){
                                    echo "Youre not registered to your departmental organization";
                                }
                            
                            ?>
                            
                        </div>
                    </div>


                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php
                             $spexistpres = false;
                            foreach($allSignatoryOrg as $sigOrg){
                                $course_id = $clearance->getStudentCourseId($user_data['program_course']);
                                $search = strtolower($user_data['program_course']) . "_president";
                                if($course_id != $sigOrg['linked_department']){
                                    $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($checkIfRegistered > 0) {
                                        $spexistpres = true;
                                        if(preg_match("/sp_president/", $sigOrg['signatory_clearance_table_name'])){
                                            $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                            if(!empty($cleared_info)){
                                                if($cleared_info['student_clearance_status'] == '1'){
                                                    echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                }else{
                                                    echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                }
                                                $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                ';
                                                echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'President</span>';
                                            }
                                        }
                                    }
                                }
                            }
                            if(!$spexistpres){
                                echo "SP does not set yet.";
                            }
                            ?>
                            
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php
                            $spexistadv = false;
                            foreach($allSignatoryOrg as $sigOrg){
                                $course_id = $clearance->getStudentCourseId($user_data['program_course']);
                                $search = strtolower($user_data['program_course']) . "_president";
                                if($course_id != $sigOrg['linked_department']){
                                    $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($checkIfRegistered > 0) {
                                        $spexistadv = true;
                                        if(preg_match("/sp_adviser/", $sigOrg['signatory_clearance_table_name'])){
                                            $cleared_info = $clearance->checkIfCleared($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                            if(!empty($cleared_info)){
                                                if($cleared_info['student_clearance_status'] == '1'){
                                                    echo '<div><i class="far fs-4 fa-check"></i></div>';
                                                }else{
                                                    echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                                }
                                                $sig_info = $signatory->getAllSignatory($sigOrg['signatory_id']);
                                                echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                                ';
                                                echo '<span class="fs-d">'. $sigOrg['signatory_workplace_name']. ' ' .'President</span>';
                                            }
                                        }
                                    }
                                }
                            }
                            if(!$spexistadv){
                                echo "SP does not set yet.";
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>  
            <?php elseif($user_data['academic_level'] == 'SHS'): ?>
            <div class="shs">
                <div class="cl-page cls mx-auto default-border shadow-sm">
                    <div class="d-flex flex-column pb-3">
                        <div class="w-100 clearance-header gap-5 d-flex align-items-center border-bottom mb-4 pb-3">
                            <div class="ccclogo">
                                <img src="../images/ccc_logo.webp" alt="ccclogo" style="height:120px;">
                            </div> 
                            <div class="text-center flex-grow-1">
                                <h1 class="m-0 fs-5">CITY COLLEGE OF CALAPAN</h1>
                                <h1 class="m-0 f-s">(Dalubhasaan ng Lungsod ng Calapan)</h1>
                                <h1 class="m-0 f-s"><em>Brgy. Guinobatan Calapan City, Oriental Mindoro</em></h1>
                                <h1 class="m-0 f-s"><em>Tel No. (02) 288-7013</em></h1>
                            </div> 
                        </div>
                        <h1 class="fs-6 text-center">CLEARANCE</h1>
                        <h1 class="f-d ms-auto"><?php echo date("M j, Y"); ?></h1>
                        <div class="t-justify">This is to certify that <strong><?php echo $user_data['first_name'] . " " . $midname . $user_data['last_name'] ; ?></strong>, with student No. <strong><?php echo $user_data['student_id']; ?></strong>, is a student of the City College of Calapan and he/she is cleared from all of his/her obligations this <?php echo $cl_info['semester']; ?>, Academic Year  <?php echo $cl_info['academic_year']; ?>. </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 text-center mb-5 berow">
                    
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                                $adviserFound = false;
                                foreach($allSignatory as $sigTable){
                                    $adv = strtolower($user_data['program_course']) . "_adviser";
                                    if(preg_match("/$adv/", $sigTable['signatory_clearance_table_name'])){
                                        $adviserFound = true;
                                        $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($cleared_info['student_clearance_status'] == '1'){
                                            echo '<div><i class="far fs-4 fa-check"></i></div>';
                                        }else{
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }
                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        
                                        echo '
                                            <hr class="my-2 c-hr mx-auto"/>
                                            <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                            <span class="fs-d">'. $user_data['program_course'] .' Adviser</span>
                                            ';
                                    }
                                }
                                if(!$adviserFound){
                                        echo '<span class="text-center c-hr mt-3">Adviser not found</span>'; 
                                }
                            ?>
                            
                        </div>

                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                            $shslib = false;
                            foreach($allSignatory as $sigTable){
                                if(preg_match("/librarian/", $sigTable['signatory_clearance_table_name'])){
                                    $shslib = true;
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                    }
                                    $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                    
                                    echo '
                                        <hr class="my-2 c-hr mx-auto"/>
                                        <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . $sig_info['last_name'].'</h1>
                                    ';
                                }
                                    
                            }
                            if(!$shslib){
                                echo "Librarian not found";
                            }
                            ?>
                            <span class="fs-d">College Librarian</span>
                        </div>

                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                            $shsgui = false;
                            foreach($allSignatory as $sigTable){    
                                if(preg_match("/guidance_office/", $sigTable['signatory_clearance_table_name'])){
                                    $shsgui = true; 
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                    }

                                    $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                    echo '
                                            <hr class="my-2 c-hr mx-auto"/>
                                            <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                        ';
                                }
                                
                            }
                            if(!$shsgui){
                                echo "Guidance not found";
                            }
                            ?>
                            <span class="fs-d">Guidance Office</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 text-center mb-5 berow">
                    
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                            $shsprin = false;
                            foreach($allSignatory as $sigTable){
                                $shsprin = true;
                                if(preg_match("/shs_principal/", $sigTable['signatory_clearance_table_name'])){
                                    $cleared_info = $clearance->checkIfCleared($sigTable['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($cleared_info['student_clearance_status'] == '1'){
                                        echo '<div><i class="far fs-4 fa-check"></i></div>';
                                    }else{
                                        echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                    }
                                    $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                    
                                    echo '
                                        <hr class="my-2 c-hr mx-auto"/>
                                        <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                        <span class="fs-d">SHS Principal</span>
                                        ';
                                }
                            }
                            if(!$shsprin){
                                echo "Principal not found";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
                    <?php endif; ?>
        </div>
        <iframe src="clearance_download_template.php?clearance_id=<?php echo $_GET['clearance_id'] ?>" id="clearanceFrame" frameborder="0" style="height: 0; border:0; width:100%;"></iframe>
            <script>     
                $(document).ready(function(){
                    $('.view-def-btn').on('click', function(){
                        let clearance_id = '<?php echo $_GET['clearance_id'] ?>'
                        let student_id = '<?php echo $user_data['student_id'] ?>'
                        let designation_table = $(this).attr('data-value');

                        $.ajax({
                            type: "POST",
                            url: "../controller/student_deficiency_view.php",
                            data: {
                                clearance_id : clearance_id,
                                designation_table: designation_table,
                                student_id: student_id,
                            },
                            success: function(response) {
                                $('#msg-area').html(response);
                            }
                        })
                    })

                    // $('#downloadBtn').click(function(){
                    //     let frame = document.getElementById('clearanceFrame').contentWindow;
                    //     frame.focus();
                    //     frame.print();
                    // });

                    let frame = document.getElementById('clearanceFrame').contentWindow;

                    $('#downloadBtn').click(function(e) {
                        var ua = navigator.userAgent.toLowerCase();
                        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
                        let frame = document.getElementById('clearanceFrame').contentWindow;
                        if (isAndroid) {
                              frame.focus();
                            frame.print();
                            AndroidPrintInterface.print();
                        } else {
                            frame.focus();
                            frame.print();
                        }   
                    });


                }) 
               
            </script>   
            
            
    </div>


    <div class="modal fade custom-modal" id="viewMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header x-border py-1 pt-3">
                    <h1 class="px-1 display-6 fs-6">Message Content</h1>
                </div>
                <div class="modal-body x-border py-0">
                        
                    <div class="px-2" id="msg-area">
                        
                    </div>
        
                    
                    <div class="d-flex justify-content-end gap-2 mb-3 mt-1 px-2">
                        <!-- <button type="submit" class="btn btn-success rounded" name="submit">Send</button> -->
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>  
<?php require_once '../includes/main_footer.php' ?>