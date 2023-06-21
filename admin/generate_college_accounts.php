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
?>
    <div class="page">
        <div class="d-flex justify-content-between align-items-center">
            <div class="fs-4">College Student Accounts</div>
            <div class="f-s">Date Printed: <?php echo date("Y/m/d"); ?></div>
        </div>
        
        <?php

        foreach($allCourse as $course){ 
            $deptCourse = $course['department_code'];

            echo '<div class="fs-6">Course: '. $deptCourse . '</div> ';
            for($i = 1; $i <= 4; $i++ ){
                
                $studentAcc = $user->getStudentAccounts($i, $deptCourse);
                if(!empty($studentAcc)){
                    
               
            
        ?>

            
            
        
        
        <div>
            <span class="fs-6 mb-0">
            <?php
                switch($i){
                    case '1' : 
                        echo $i . "st Year";
                    break ;
                    case '2' : 
                        echo $i . "nd Year";
                    break ;
                    case '3' : 
                        echo $i . "rd Year";
                    break ;
                    case '4' : 
                        echo $i . "th Year";
                    break ;
                }
            ?>
            </span>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($studentAcc as $acc): ?>
                        <tr>
                            <td><?php echo $acc['student_id'];  ?></td>
                            <td><?php echo $acc['email'];  ?></td>
                            <td><?php echo $acc['password'];  ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <br>
        </div>

        <?php 
                    }
                } 
            }   ?>
    </div>
<?php require_once '../includes/main_footer.php' ?>