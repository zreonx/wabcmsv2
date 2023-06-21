<?php 
    require_once '../includes/main_header.php'; 
    $checkUser = $user->getSignatoryAccount();

?>
<style>
    body {
        background-color: #f8f9fa;
    }
</style>
    <div class="page">
    <div class="report-card">
        <h1 class="page-title fs-5 display-6 ">Generate Account </h1>
            <div class="report-items">
                <button type="button" id="collegeBtn" class="text-decoration-none text-dark border-0">
                    <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                        
                            <div class="r-icon fs-5 text-success">
                            <i class="fas fa-file-user"></i>
                            </div>
                            <h1 class="display-6 fs-6 m-0">College</h1>
                    </div>
                </button>
                <button type="button" id="shsBtn" class="text-decoration-none text-dark border-0">
                    <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                            <div class="r-icon fs-5 text-success">
                            <i class="fas fa-file-user"></i>
                            </div>
                            <h1 class="display-6 fs-6 m-0">SHS</h1>
                    </div>
                </button>
                <button type="button" id="signatoryBtn" class="text-decoration-none text-dark border-0">
                    <div class="r-acc d-flex gap-3 justify-content-center align-items-center">
                            <div class="r-icon fs-5 text-success">
                            <i class="fas fa-file-user"></i>
                            </div>
                            <h1 class="display-6 fs-6 m-0">Signatories</h1>
                    </div>
                </button>
            </div>
            
        </div>

        <iframe src="generate_college_accounts.php" id="collegeAccounts" frameborder="0" style="height: 0; border:0; width:100%;"></iframe>
        <iframe src="generate_shs_accounts.php" id="shsAccounts" frameborder="0" style="height: 0; border:0; width:100%;"></iframe>
        <iframe src="generate_signatory_accounts.php" id="signatoryAccounts" frameborder="0" style="height: 0; border:0; width:100%;"></iframe>
        <script>
           $(document).ready(function(){
                console.log("test");
                let frame = document.getElementById('collegeAccounts').contentWindow;
                let frame2 = document.getElementById('shsAccounts').contentWindow;
                let frame3 = document.getElementById('signatoryAccounts').contentWindow;
                $('#collegeBtn').click(function() {
                    frame.focus();
                    frame.print();
                });
                $('#shsBtn').click(function() {
                    frame2.focus();
                    frame2.print();
                });
                $('#signatoryBtn').click(function() {
                    frame3.focus();
                    frame3.print();
                });
           })
        </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>