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
    <link rel="stylesheet" href="../css/main.css?v1.18">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-2.24.1.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.min.js"></script>

    <script src="../js/all.min.js"></script>
    <script src="../js/main.js?v.1"></script>
    <script src="../js/fileupload.js"></script>
    <script src="../js/datatable.js?v1.2"></script>

</head>
<body>

<div class="sidenav navbar-expand d-flex flex-column align-items-start sidebar-open me-0" id="sidebar">
    <div class="sidenav-logo d-flex justify-content-center align-items-center w-100 mt-3">
        <a href="#" class=""> 
            <img class="side-logo img-fluid" style="height: 150px" src="../images/ccc_logo.webp" alt="logo">
        </a>
    </div>


    <?php       
        // if(isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'admin' ) {
        //     include_once 'users/admin_sidebar.php';
        // }else if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'signatory') {
        //     include_once 'users/signatory_sidebar.php';
        // }else if(isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'student'){
        //     include_once 'users/student_sidebar.php';
        // }
    ?>

    <?php if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'admin' ):?>

    <!-- Admin Header -->
    <div class="sidenav-category mt-2">
        <div class="custom-category">
            <a class="category-btn clink-text-single" href="index.php" >
                <div>
                    <i class="fas fa-tachometer-slowest mx-2"></i>
                    <span class="category-text">Dashboard</span>
                </div>
            </a>
        </div>
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fas fa-building mx-2"></i>
                    <span class="category-text">Workplace Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><span class="chev"></span><a class="clink-text" href="org_management.php">Organizations</a></li>
                <li class="category-link"><a class="clink-text" href="dept_management.php">Departments</a></li>
                <li class="category-link"><a class="clink-text" href="office_management.php">Offices</a></li>
                <li class="category-link"><a class="clink-text" href="shs_management.php">SHS</a></li>
            </ul>
        </div>

        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fas fa-chair-office mx-2"></i>
                    <span class="category-text">Designation Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a class="clink-text" href="add_designation_information.php">Designations</a></li>
            </ul>
        </div>
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fas fa-file-alt mx-2"></i>
                    <span class="category-text">Clearance Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="clearance_management.php" class="clink-text">Clearance</a></li>
                <li class="category-link"><a href="clearance_request.php" class="clink-text">Clearance Requests</a></li>
                
            </ul>
        </div>
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fad fa-user-tag mx-2"></i>
                    <span class="category-text">Signatory Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="signatory_management.php" class="clink-text">Signatories</a></li>                
            </ul>
        </div>
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fad fa-users mx-2"></i>
                    <span class="category-text">Student Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="student_management.php" class="clink-text">Students</a></li>            
            </ul>
        </div>
        
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fas fa-user mx-2"></i>
                    <span class="category-text">User Accounts</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a class="clink-text" href="users_management.php">Accounts</a></li>              
            </ul>
        </div>
        
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fal fa-chart-line mx-2"></i>
                    <span class="category-text">Reports</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="reports.php" class="clink-text">Report Records</a></li>              
            </ul>
        </div>
    </div>

    

    <?php elseif (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'signatory'): ?>
        <?php 
            $allOrganization = $organization->getAllOrganizations();
            $category_id = $organization->getOrganizationCategoryId("Organization");
            $orgSig = $organization->getOrganizationSignatory($category_id['id'], $_SESSION['user_id']);
         ?>

    <!-- Signatory sidebar -->
    <div class="sidenav-category mt-2">
        <!-- <div class="custom-category">
            <a class="category-btn clink-text-single" href="index.php" >
                <div>
                    <i class="fas fa-tachometer-slowest mx-2"></i>
                    <span class="category-text">Dashboard</span>
                </div>
            </a>
        </div> -->

        <div class="custom-category">
            <a class="category-btn clink-text-single" href="clearance_management.php" >
                <div>
                    <i class="fas fa-file-alt mx-2"></i>
                    <span class="category-text">Clearance Management</span>
                </div>
            </a>
        </div>
        <?php if(!empty($orgSig)): ?>
            <div class="custom-category">
                <div class="category-btn">
                    <div>
                        <i class="fas fa-sitemap mx-2"></i>
                        <span class="category-text">Organization Management</span>
                    </div>
                    <i class='fal fa-chevron-down' id="chevron"></i>
                </div>
                <ul class="category-item p-0">
                    <?php foreach($orgSig as $org_sig): ?>
                        <li class="category-link"><a href="organization_management.php?organization_id=<?php echo $org_sig['id']; ?>&code=<?php echo $org_sig['organization_code']; ?>" class="clink-text"><?php echo $org_sig['organization_code'] ?> Members</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fas fa-file-alt mx-2"></i>
                    <span class="category-text">Clearance Management</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="clearance_management.php" class="clink-text">Clearance</a></li>
            </ul>
        </div> -->

        
        <!-- <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fal fa-chart-line mx-2"></i>
                    <span class="category-text">Reports</span>
                </div>
                <i class='fal fa-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="reports.php" class="clink-text">Report Records</a></li>              
            </ul>
        </div> -->
    </div>


    <?php elseif (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'student'): ?>

    <!-- Student sidebar -->
    <div class="sidenav-category mt-2">

        <div class="custom-category">
            <a class="category-btn clink-text-single" href="index.php" >
                <div>
                <i class="fas fa-file-alt mx-2"></i>
                    <span class="category-text">Clearance</span>
                </div>
            </a>
        </div>

        <div class="custom-category">
            <a class="category-btn clink-text-single" href="request_clearance.php" >
                <div>
                <i class="fas fa-tasks mx-2"></i>
                    <span class="category-text">Request Clearance</span>
                </div>
            </a>
        </div>

    </div>

    <?php endif; ?>

</div>

    <div class="main-content">
        <?php if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'admin' ):?>
        <?php endif; ?>
        <div class="side-header d-flex align-items-center justify-content-between">
            <button class="btn btn-menu"><i class="far fa-bars"></i></button>
           <div class="d-flex">
                <!-- <div class="notif d-flex align-items-center" id="notif-btn">
                    <img src="https://zreonph.sirv.com/wabcms_images/bell%20.png" style="height: 26px;" alt="">
                </div>
                <div class="notif-menu">
                    <ul>
                        <li><a href="settings.php">Transfering Clearance</a></li>
                        <li><a href="settings.php">Transfering Clearance</a></li>
                        <li><a href="settings.php">Transfering Clearance</a></li>
                        <li><a href="settings.php">Transfering Clearance</a></li>
                    </ul>
                </div> -->

                
                
           </div>
           <div class="profile me-3 d-flex align-items-center gap-2" id="profile-btn">
                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="img-fluid" style="height: 24px;" alt="">
                    <span class="f-d">Profile</span>
                </div>
            <div class="profile-menu">
                <ul>
                    <li><i class="fas fa-sliders-h profile-icon"></i><a href="settings.php">Settings</a></li>
                    <li><i class="fas fa-sign-out-alt profile-icon"></i><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
            
        </div>
        


    <!-- Signatory Header -->

