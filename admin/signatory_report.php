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
    $studentUser = $user->getStudentAccount();
    $allCourse = $user->getAllCourse();

    $allDesignations = $user->allDesignation();
    
?>
    <div class="page">
        <div class="d-flex justify-content-between align-items-center">
            <div class="fs-4">Signatory Information Report</div>
            <div class="f-s">Date Printed: <?php echo date("Y/m/d"); ?></div>
        </div>

        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Workplace</th>
                        <th>Designation</th>
                        <th>Full Name</th>
                        <th>Date Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; foreach($allDesignations as $acc): ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php 
                                 echo $designation->getWorkplace($acc['category'], $acc['signatory_workplace']);
                            ?></td>
                        <td><?php echo $acc['designation'] ?></td>
                        <td><?php echo $acc['last_name'] . ", " . $acc['first_name'] . " " . $acc['middle_name'] ?></td>
                        <td><?php echo $acc['date_assigned'] ?></td>
                    </tr>
                    <?php $count++; endforeach; ?>
                </tbody>
            </table>
            
        </div>

    </div>
<?php require_once '../includes/main_footer.php' ?>