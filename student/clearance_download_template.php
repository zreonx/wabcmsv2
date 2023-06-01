<html lang="en">
    <?php require_once '../config/connection.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WABCMS V2</title>

    <link rel="icon" href="../images/ccc_logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="../css/bootstrap.min.css?v.1">
    <link href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.css?v.1" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/main.css?v1.28">
    <link rel="stylesheet" href="../css/all.min.css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css" />

    <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    

    <script src="../js/all.min.js"></script>
    <script src="../js/main.js?v.4"></script>
    <script src="../js/datatable.js?v1.2"></script>

</head>
<body>

<?php 
    
    $clearance_id = $_GET['clearance_id'];

    $cl_info = $clearance->getActiveClearanceById($clearance_id);
    $user_data = $_SESSION['user_data'];

    $midinit = strtoupper(substr($user_data['middle_name'], 0, 1)) . ". ";

    $midname = ($user_data['middle_name'] == '') ? ' ' : $midinit;

    $allSignatory = $clearance->allActiveSignatoryTable();

    $allSignatoryOrg = $clearance->allActiveSignatoryTableOrg();

?>
    <div class="page x-border">

        <div class="page-content rounded x-border">
            <?php if($user_data['academic_level'] == 'College'): ?>
            <div class="college"> 
                <div class="cl-page mx-auto default-border">
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
                    <div class="d-flex flex-column pb-3">
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
                            foreach($allSignatory as $sigTable){
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
                            ?>
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
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }
                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                            ';
                                        
                                    }   
                                    
                            }
                            ?>
                            <span class="fs-d">Program Head</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                        <?php 
                            foreach($allSignatory as $sigTable){
                                    if(preg_match("/sas/", $sigTable['signatory_clearance_table_name'])){
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
                            ?>
                            <span class="fs-d">Director, Student Affair and Services</span>
                        </div>
                    </div>

                </div>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>

                <div class="cl-page mx-auto default-border mt-5 ">
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
                                    if(preg_match("/adviser/", $sigOrg['signatory_clearance_table_name'])){
                                        if($course_id != $sigOrg['linked_department'] AND !preg_match("/sp/", $sigOrg['signatory_clearance_table_name'])){
                                            if($checkIfRegistered > 0) {
                                                $yourOrg = true;
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
                               
                            ?>
                            
                        </div>

                        
                        

                        
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php 
                                $deptorgfoundpres = false;
                                foreach($allSignatoryOrg as $sigOrg){
                                    $course_id = $clearance->getStudentCourseId($user_data['program_course']);

                                    $search = strtolower($user_data['program_course']) . "_president";

                                    if($course_id == $sigOrg['linked_department']){

                                        $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($checkIfRegistered > 0) {
                                            if(preg_match("/president/", $sigOrg['signatory_clearance_table_name'])){
                                                $deptorgfoundpres = true;
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

                                        }else{
                                            echo "Youre not registered to your departmental organization";
                                        }
                                    }
                                }
                                if(!$deptorgfoundpres){
                                    echo "Your department does not have an organization";
                                }
                            
                            ?>
                            
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php 
                                $deptorgfoundadv = false;
                                foreach($allSignatoryOrg as $sigOrg){
                                    $course_id = $clearance->getStudentCourseId($user_data['program_course']);

                                    $search = strtolower($user_data['program_course']) . "_president";

                                    if($course_id == $sigOrg['linked_department']){

                                        $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                        if($checkIfRegistered > 0) {
                                            if(preg_match("/adviser/", $sigOrg['signatory_clearance_table_name'])){
                                                $deptorgfoundadv = true;
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

                                        }else{
                                            echo "Youre not registered to your departmental organization";
                                        }
                                    }
                                }
                                if(!$deptorgfoundadv){
                                    echo "Your department does not have an organization";
                                }
                            
                            ?>
                            
                        </div>
                    </div>


                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php
                            
                            foreach($allSignatoryOrg as $sigOrg){
                                $course_id = $clearance->getStudentCourseId($user_data['program_course']);
                                $search = strtolower($user_data['program_course']) . "_president";
                                if($course_id != $sigOrg['linked_department']){
                                    $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($checkIfRegistered > 0) {
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
                            ?>
                            
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-evenly text-center px-5 mb-5">
                        <div class="d-flex flex-column justify-content-center">
                            <?php
                            
                            foreach($allSignatoryOrg as $sigOrg){
                                $yourOrg = false;
                                $course_id = $clearance->getStudentCourseId($user_data['program_course']);
                                $search = strtolower($user_data['program_course']) . "_president";
                                if($course_id != $sigOrg['linked_department']){
                                    $checkIfRegistered = $clearance->checkIfStudentIsInside($sigOrg['signatory_clearance_table_name'], $user_data['student_id'], $clearance_id);
                                    if($checkIfRegistered > 0) {
                                        $yourOrg = true;
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
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>  
            <?php elseif($user_data['academic_level'] == 'SHS'): ?>
            <div class="shs">
                <div class="cl-page cls mx-auto default-border">
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
                    <div class="d-flex flex-column pb-3">
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
                                            <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . $sig_info['last_name'].'</h1>
                                        ';
                                    }
                                    
                            }
                            ?>
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
                                            echo '<div data-bs-toggle="tooltip" title="View Deficiency"><div class="d-flex align-items-center gap-2 justify-content-center view-def-btn" data-value="'. $sigTable['signatory_clearance_table_name'] .'" id="view-def-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"><i class="fal fs-4 text-danger fa-exclamation-circle"></i><a class="f-s text-decoration-none text-success">View Message<a></div></div>';
                                        }

                                        $sig_info = $signatory->getAllSignatory($sigTable['signatory_id']);
                                        echo '
                                                <hr class="my-2 c-hr mx-auto"/>
                                                <h1 class="f-d m-0">'. $sig_info['first_name'] . ' ' . $sig_info['middle_name'] . ' ' . $sig_info['last_name'].'</h1>
                                            ';
                                    }
                                
                            }
                            ?>
                            <span class="fs-d">Guidance Office</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 text-center mb-5 berow">
                    
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <?php 
                            foreach($allSignatory as $sigTable){
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
                            ?>
                        </div>
                    </div>
                </div>
            </div>
                    <?php endif; ?>
        </div>
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
                }) 
               
            </script>   
            
            
            <iframe src="clearance_template.php?clearance_id=<?php echo $_GET['clearance_id'] ?>" id="clearanceFrame" frameborder="0" style="height: 0; border:0; width:100%;"></iframe>
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

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/wkhtmltopdf@0.4.0/index.min.js"></script>

</body>
</html>