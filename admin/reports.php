<?php 
    require_once '../includes/main_header.php'; 
    $allUser = $user->getAllUser();
?>
<style>
    body {
        background-color: #f8f9fa;
    }
</style>
    <div class="page">

        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Reports</h1>
        <div class="page-content p-2 rounded ">
           <div class="report-card">
                <div class="report-items">
                    <a href="generate_accounts.php" class="text-decoration-none text-dark">
                        <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                            
                                <div class="r-icon fs-5 text-success">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h1 class="display-6 fs-6 m-0">Generate Accounts</h1>
                        </div>
                   </a>
                   <a href="generate_accounts.php" class="text-decoration-none text-dark">
                        <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                                <div class="r-icon fs-5 text-success">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h1 class="display-6 fs-6 m-0">Clearance Report</h1>
                        </div>
                    </a>
                    <a href="generate_accounts.php" class="text-decoration-none text-dark">
                        <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                                <div class="r-icon fs-5 text-success">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h1 class="display-6 fs-6 m-0">Signatory Report</h1>
                        </div>
                   </a>
                   <a href="generate_accounts.php" class="text-decoration-none text-dark">
                        <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                                <div class="r-icon fs-5 text-success">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h1 class="display-6 fs-6 m-0">Student Clearance Report</h1>
                        </div>
                    </a>
                    <a href="generate_accounts.php" class="text-decoration-none text-dark">
                        <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                                <div class="r-icon fs-5 text-success">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h1 class="display-6 fs-6 m-0">Student List Report</h1>
                        </div>
                    </a>
                </div>
           </div>
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>