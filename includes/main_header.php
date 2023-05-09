<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WABCMS V2</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.css?v.1" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/main.css?v1.1">
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
   
    <script src="../js/main.js?v.3"></script>

    <script src="../js/datatable.js"></script>
</head>
<body>

<div class="sidenav navbar-expand d-flex flex-column align-items-start sidebar-open" id="sidebar">
    <div class="sidenav-logo d-flex justify-content-center align-items-center w-100 mt-3">
        <a href="#" class=""> 
            <img class="side-logo img-fluid" style="height: 150px" src="../images/ccc_logo.webp" alt="logo">
        </a>
    </div>
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
                <i class='bx bx-chevron-down' id="chevron"></i>
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
                <i class='bx bx-chevron-down' id="chevron"></i>
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
                <i class='bx bx-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="clearance_management.php" class="clink-text">Clerance</a></li>
                <li class="category-link"><a class="clink-text">Clearance Requests</a></li>
                
            </ul>
        </div>
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fad fa-user-tag mx-2"></i>
                    <span class="category-text">Signatory Management</span>
                </div>
                <i class='bx bx-chevron-down' id="chevron"></i>
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
                <i class='bx bx-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a href="student_management.php" class="clink-text">Students</a></li>
                <li class="category-link"><a class="clink-text">Add Signatory</a></li>                
            </ul>
        </div>
        
        <div class="custom-category">
            <div class="category-btn">
                <div>
                    <i class="fal fa-chart-line mx-2"></i>
                    <span class="category-text">Reports</span>
                </div>
                <i class='bx bx-chevron-down' id="chevron"></i>
            </div>
            <ul class="category-item p-0">
                <li class="category-link"><a class="clink-text">Report Records</a></li>              
            </ul>
        </div>
    </div>

</div>

    <div class="main-content">
        <div class="side-header d-flex align-items-center">
            <button class="btn btn-menu"><i class="far fa-bars"></i></button>
        </div>

