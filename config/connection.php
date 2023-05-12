<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'wabcms_db');
    define('DB_CHARSET', 'utf8mb4');

    // define('DB_HOST', 'sql208.epizy.com');
    // define('DB_USER', 'epiz_34001244');
    // define('DB_PASS', 'jg9BK25Lv8J');
    // define('DB_NAME', 'epiz_34001244_wabcms_db');
    // define('DB_CHARSET', 'utf8mb4');


    include_once '../includes/autoloader.inc.php';
    //include_once '../includes/session.php';


    $db = new DatabaseConnection();
    $conn = $db->Conn();

    $organization = new Organization($conn);
    $department = new Department($conn);
    $office = new Offices($conn);
    $shs = new Shs($conn);
    $designation_category = new DesignationCategory($conn);
    $designation = new Designation($conn);
    $signatory = new Signatory($conn);
    $student = new Student($conn);
    $clearance = new Clearance($conn);


    // $clearance = new Clearance($conn);
    // $students = new Student($conn);
    // $signatories = new Signatory($conn);
    // $errors = new Error();
    // $displayPage = new Paging($conn);
    // $dashboard = new Dashboard($conn);
    // $searchFilter = new SearchFilter($conn);
    // $users = new User($conn);
    // $report = new Report($conn);

    // Signatory classes
    // $signatoryClearance = new SignatoryClearance($conn);

    //Student classes
    //$studentClearance = new StudentClearance($conn);
    



   