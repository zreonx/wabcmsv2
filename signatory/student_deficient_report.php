<html lang="en">
    
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
    
</head>
<body>
<?php require_once '../config/connection.php'; ?>
<?php 

    $clearance_id = $_GET['clearance_id'];
    $table_name = $_GET['designation_table'];
    // $table_name = 'sdb_co_president_19';
    // $clearance_id = 26;
    $clearanceInfo = $report->getClearanceInfo($clearance_id);
    $allSignatory = $report->getDeficientSignatoryStudents($table_name, $clearance_id);

?>
    <div class="page">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fs-4">Deficient Student Report</div>
            <div class="f-s">Date Printed: <?php echo date("Y/m/d"); ?></div>
        </div>
        <div class="mb-2">
            <h1 class="f-s display-6 mb-1">Clearance Reference Number: <?php echo $clearance_id ?></h1>
            <h1 class="f-s display-6 mb-1">Clearance Type: <?php echo $clearanceInfo['clearance_name']; ?></h1>
            <h1 class="f-s display-6 mb-1">Recipient: <?php echo $clearanceInfo['clearance_beneficiary']; ?></h1>
            <h1 class="f-s display-6 mb-1">Semester: <?php echo $clearanceInfo['semester']; ?></h1>
            <h1 class="f-s display-6 mb-1">Year: <?php echo $clearanceInfo['academic_year']; ?></h1>
        </div>

        <div>
            <div class="text-center"> <?php echo strtoupper(str_replace("_", " ", substr($table_name, 3, -2))); ?></div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date Cleared</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; foreach($allSignatory as $studClearance): ?>
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo $studClearance['student_id'] ?></td>
                                <td><?php echo $studClearance['last_name'] . ", " . $studClearance['first_name'] . " " . $studClearance['middle_name'] ?></td>
                                <td>
                                    <?php
                                        if($studClearance['student_clearance_status'] == '1'){
                                            echo "Cleared";
                                        }else if($studClearance['student_clearance_status'] == '2'){
                                            echo "Unsigned";
                                        }else {
                                            echo "Deficient";
                                        }
                                    ?>
                                </td>
                                <td>
                                    -
                                    <?php
                                        // $timestamp = strtotime($studClearance['date_cleared']);
                                        // $formatted_date = date('Y/m/d', $timestamp);
                                        // echo $formatted_date; 
                                    ?>
                                </td>
                            </tr>
                        <?php $count++; endforeach; ?>
                        
                    </tbody>
                </table>
            </div>
        </div>


        

        
    </div>
<?php require_once '../includes/main_footer.php' ?>
