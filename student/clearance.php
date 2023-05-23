<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearance();
    $user_data = $_SESSION['user_data'];
    
?>
    <div class="page px-4">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Finals Clearance - 1st Semester (2022-2023)</h1>
        <div class="page-content rounded">
            

        </div>

            <script>      
    
               
            </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>