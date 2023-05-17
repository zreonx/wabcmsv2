<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearance();
    $user_data = $_SESSION['user_data'];

    $organizations = $organization->getAllOrganizations();
    $clearanceInfo = $clearance->getClearanceInfo($_GET['clearance_id']);
    $clearanceInfo = $clearanceInfo->fetch(PDO::FETCH_ASSOC);

    $sig_tb_content = $clearance->getSignatoryDesignationTableStudent($_GET['designation_workplace'], $_GET['clearance_id']);
    
?>
    <div class="page px-4">
        <?php 
            if (isset($_GET['import']) && $_GET['import'] == "success") { echo '<div class="alert alert-success" id="err">Deficiency has been added.</div>'; }
            if (isset($_GET['error']) && $_GET['error'] == "true") { echo '<div class="alert alert-danger" id="err">There was an error importing students.</div>'; } 
            if (isset($_GET['import']) && $_GET['import'] == "empty") { echo '<div class="alert alert-danger" id="err">Please select a CSV file.</div>'; }
            if (isset($_GET['import']) && $_GET['import'] == "invalid") {echo '<div class="alert alert-danger" id="err">Please select an appropriate file format</div>';}
            if (isset($_GET['column']) && $_GET['column'] == "false") { echo '<div class="alert alert-danger" id="err">The column of the file does not match our database.</div>'; }
        ?>
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title fs-5 display-6">Designation</h1>
            <div class="d-flex gap-2 flex-wrap align-items-center justify-content-center">
                <?php
                    $is_org = false;
                    foreach($organizations as $orgs){
                        if($_GET['workplace'] == $orgs['organization_code']){
                            $is_org = true;
                            break;
                        }
                    }

                    if($is_org):
                ?>
                    <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOrg"><i class="fas me-1 fa-plus"></i> Import Organization Member</div>
                <?php else: ?>
                    <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOther"><i class="fas me-1 fa-plus"></i> Import Deficient Student</div>
                <?php endif; ?>
                
            </div>
        </div>
        <div class="page-content p-2 rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fs-5 display-6 py-1 m-0"><i class="fas fa-mail-bulk text-success"></i> <?php echo (isset($_GET['designation_workplace'])) ? strtoupper(str_replace("_", " ", substr($_GET['designation_workplace'], 3, -1))) : 'Not Available'; ?></h1>
                <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fas me-1 fa-thumbs-up"></i> Submit Deficiency</div>
            </div>

           
            <div class="default-border rounded-end mb-2 w-100 d-flex ">
                <div class="f-d badge bg-success rounded-0 rounded-start" data-bs-toggle="tooltip" title="Clearance Reference Number">CRN <?php echo($_GET['clearance_id']); ?></div>
                <div class="d-flex justify-content-between align-items-center flex-grow-1 px-2">
                    <h1 class="f-d display-6 mb-0"><?php echo $clearanceInfo['clearance_name'] ?></h1>
                    <h1 class="f-d display-6 mb-0"><?php echo $clearanceInfo['semester'] ?></h1>
                    <h1 class="f-d display-6 mb-0">A.Y. <?php echo $clearanceInfo['academic_year'] ?></h1>
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
                                    <td><?php echo ($des_student['academic_level'] < 5) ?></td>
                                    <td><?php echo $des_student['program_course'] ?></td>
                                    <td>
                                        <?php 
                                            switch($des_student['year_level']){
                                                case '1' : 
                                                    echo $des_student['year_level'] . "st Year";
                                                break ;
                                                case '2' : 
                                                    echo $des_student['year_level'] . "nd Year";
                                                break ;
                                                case '3' : 
                                                    echo $des_student['year_level'] . "rd Year";
                                                break ;
                                                case '4' : 
                                                    echo $des_student['year_level'] . "th Year";
                                                break ;
                                                default:
                                                    echo 'Grade ' . $des_student['year_level'];
                                                break ;
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo ($des_student['student_clearance_status'] == "1") ? '<div class=""><div class="badge-green"><i class="fas fa-check-circle i-dot i-success "></i> <span>Cleared</span></div></div>' : '<div class=""><div class="badge-danger"><i class="fas fa-exclamation-circle i-dot i-danger "></i> <span class="text-gray">Deficient</span></div></div>'; ; ?></td>
                                    <td><button data-id="<?php $des_student['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn" <?php echo ($des_student['student_clearance_status'] == "1") ? 'disabled' : '' ; ?> ><i class="far fa-user-check"></i> Clear</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                            
                    
                    </table>

                    <div class="modal fade custom-modal" id="importOrg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Import Organization Members</h1>
                                </div>
                                <div class="modal-body x-border py-0">
                                    <form class="px-3 pb-3" action="../controller/signatory_import_org.php" method="post" enctype="multipart/form-data">
                                        <div class="file-upload">
                                            <label>
                                                <input type="file" class="form-control" name="csvfile" accept=".csv">
                                                <span>Choose CSV file or drag it here</span>
                                            </label>
                                        </div>   

                                        <input type="hidden" name="signatory_id" value="<?php echo $user_data['id']; ?>">
                                        <input type="hidden" name="clearance_id" value="<?php echo $_GET['clearance_id']; ?>">
                                        <input type="hidden" name="semester" value="<?php echo $clearanceInfo['semester'] ?>">
                                        <input type="hidden" name="academic_year" value="<?php echo $clearanceInfo['academic_year'] ?>">
                                        <input type="hidden" name="url_info_string" value="<?php echo 'clearance_id='. $_GET['clearance_id'] .'&workplace='. $_GET['workplace'] .'&designation_workplace= '. $_GET['designation_workplace'] ?>">
                                        <input type="hidden" name="designation_table" value="<?php echo $_GET['designation_workplace']; ?>">
                                       
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-success rounded" name="submit">Import</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade custom-modal" id="importOther" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Import Deficient Student</h1>
                                </div>
                                <div class="modal-body x-border py-0">
                                    <form class="px-3 pb-3" action="../controller/signatory_import_other.php" method="post" enctype="multipart/form-data">
                                    
                                    <div class="file-upload">
                                        <label>
                                            <input type="file" class="form-control" name="csvfile" accept=".csv">
                                            <span>Choose CSV file or drag it here</span>
                                        </label>
                                    </div>   
                                    
                                    <div class="px-3 py-2">
                                            <div class="input-cont mb-2">
                                                <textarea class="input-box" name="message" id="message" cols="30" rows="3" required></textarea>
                                                <label class="input-label">Input Message Deficiency</label>
                                            </div>
                                        
                                            
                                            <input type="hidden" name="signatory_id" value="<?php echo $user_data['id']; ?>">
                                            <input type="hidden" name="clearance_id" value="<?php echo $_GET['clearance_id']; ?>">
                                            <input type="hidden" name="semester" value="<?php echo $clearanceInfo['semester'] ?>">
                                            <input type="hidden" name="academic_year" value="<?php echo $clearanceInfo['academic_year'] ?>">
                                            <input type="hidden" name="url_info_string" value="<?php echo 'clearance_id='. $_GET['clearance_id'] .'&workplace='. $_GET['workplace'] .'&designation_workplace= '. $_GET['designation_workplace'] ?>">
                                            <input type="hidden" name="designation_table" value="<?php echo $_GET['designation_workplace']; ?>">


                                            <div class="success-notice f-s my-2"><i class="fal fa-question-circle"></i> Note: This will add deficiencies simultaneously to those included in chosen file , please review your action before proceeding.</div>
                                       </div>

                                       
                                       

                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-success rounded" name="submit">Import</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <script>      
                
               
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>