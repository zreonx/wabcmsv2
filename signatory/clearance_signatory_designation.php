<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearance();
    $user_data = $_SESSION['user_data'];

    $sig_tb_content = $clearance->getSignatoryDesignationTableStudent($_GET['designation_workplace'], $_GET['clearance_id']);
    
?>
    <div class="page px-4">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Designation</h1>
        <div class="page-content p-2 rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fs-5 display-6 py-1 m-0"><i class="fas fa-mail-bulk text-success"></i> <?php echo (isset($_GET['designation_workplace'])) ? strtoupper(str_replace("_", " ", substr($_GET['designation_workplace'], 3, -1))) : 'Not Available'; ?></h1>
                <h1 class="f-d badge bg-success" data-bs-toggle="tooltip" title="Clearance Reference Number">CRN <?php echo($_GET['clearance_id']); ?></h1>
            </div>

           
            <div class="clearance-info py-2 px-3 default-border mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="f-d display-6 mb-0">Finals Clearance</h1>
                    <h1 class="f-d display-6 mb-0">1st Semester</h1>
                    <h1 class="f-d display-6 mb-0">A.Y. 2022-2023</h1>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end mb-2 ">
                <h1 class="fs-6 display-6 mb-0">Students</h1>
                <div class="form-group d-flex gap-2">
                    <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                    <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                </div>
            </div>  
            <div>
                <div class="custom-table px-3 pb-3">
                    <table class="table display w-100 mb-2" id="my-datable"">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Education Level</th>
                                <th>Program | Course</th>
                                <th>Academic Level</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sig_tb_content as $des_student): ?>
                                <tr>
                                <td><?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] //strtoupper(substr($stud_row['middle_name'], 0, 1)) ."." ?></td>
                                    <td><?php echo $des_student['academic_level'] ?></td>
                                    <td><?php echo $des_student['program_course'] ?></td>
                                    <td><?php echo $des_student['year_level'] ?></td>
                                    <td><?php echo ($des_student['student_clearance_status'] == "1") ? '<div class=""><div class="badge-green"><i class="fas fa-check-circle i-dot i-success "></i> <span>Cleared</span></div></div>' : ''; ; ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                            
                    
                    </table>
                </div>
            </div>

            

            <script>      
                
               
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>