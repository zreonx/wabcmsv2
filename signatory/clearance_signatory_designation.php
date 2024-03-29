<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearance();
    $user_data = $_SESSION['user_data'];

    $organizations = $organization->getAllOrganizations();
    $clearanceInfo = $clearance->getClearanceInfo($_GET['clearance_id']);
    $clearanceInfo = $clearanceInfo->fetch(PDO::FETCH_ASSOC);

    $designation_workplace = $_GET['designation_workplace'];

    $clearance_id = $_GET['clearance_id'];

    $sig_tb_content = $clearance->getSignatoryDesignationTableStudent($designation_workplace, $clearance_id);

    $sumitDeficiencyStatus = $clearance->checkDeficiencySubmitStatus($clearance_id, $designation_workplace);

    
?>
    <div class="page px-4">
        <?php 
            if (isset($_GET['import']) && $_GET['import'] == "success") { echo '<div class="alert alert-success" id="err">Deficiency has been added.</div>'; }
            if (isset($_GET['error']) && $_GET['error'] == "true") { echo '<div class="alert alert-danger" id="err">There was an error importing students.</div>'; } 
            if (isset($_GET['import']) && $_GET['import'] == "empty") { echo '<div class="alert alert-danger" id="err">Please select a CSV file.</div>'; }
            if (isset($_GET['import']) && $_GET['import'] == "invalid") {echo '<div class="alert alert-danger" id="err">Please select an appropriate file format</div>';}
            if (isset($_GET['column']) && $_GET['column'] == "false") { echo '<div class="alert alert-danger" id="err">The column of the file does not match our database.</div>'; }
        ?>
        <div class="d-flex flex-wrap gap-2 justify-content-lg-between align-items-center">
            <h1 class="page-title fs-5 display-6">Designation</h1>
            <div class="d-flex gap-2 align-items-center justify-content-center ms-auto"> 
                <?php
                    $is_org = false;
                    foreach($organizations as $orgs){
                        if($_GET['workplace'] == $orgs['organization_code']){
                            $is_org = true;
                            break;
                        }
                    }
                if(!$sumitDeficiencyStatus['cd_status'] == "1"):
                    if($is_org):
                ?>
                    <!-- <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOrg"><i class="fas fa-user-plus"></i> Add Member</div> -->
                    <div id="imports">
                        <!-- <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOrg"><i class="fas me-1 fa-plus"></i> Import Organization Member</div> -->
                        <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOther"><i class="fas me-1 fa-plus"></i> Import Deficient Student</div>
                    </div>
                <?php else: ?>
                    <div id="imports">
                        <!-- <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOrg"><i class="fas me-1 fa-plus"></i> Import Organization Member</div> -->
                        <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importOther"><i class="fas me-1 fa-plus"></i> Import Deficient Student</div>
                    </div>       
                <?php endif; ?>
                <?php endif; ?>
                
            </div>
        </div>
        <div class="page-content p-2 rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fs-5 display-6 py-1 m-0"><i class="fas fa-mail-bulk text-success"></i> <?php echo (isset($_GET['designation_workplace'])) ? strtoupper(str_replace("_", " ", substr($_GET['designation_workplace'], 3, -1))) : 'Not Available'; ?></h1>
                <div>
                    <div type="button" data-id="<?php echo $_GET['clearance_id']; ?>" data-value="<?php echo $_GET['designation_workplace']; ?>" class="btn btn-success rounded mb-3" id="clearAllBtn"  data-bs-toggle="modal" data-bs-target="#clearAllConfirm"><i class="fad fa-check me-1"></i>Clear All</div>
                    <?php if($sumitDeficiencyStatus['cd_status'] == "1"): ?>

                        <div data-id="<?php echo $_GET['clearance_id']; ?>" data-value="<?php echo $_GET['designation_workplace']; ?>" class="btn btn-danger rounded mb-3" id="submitDeficiencyBtn">Cancel</div>

                    <?php else: ?>
                        
                        <div data-id="<?php echo $_GET['clearance_id']; ?>" data-value="<?php echo $_GET['designation_workplace']; ?>" class="btn btn-success rounded mb-3" id="submitDeficiencyBtn"><i class="fas me-1 fa-thumbs-up"></i> Submit Deficiency</div>
                    
                    <?php endif; ?>
                </div>
                <div class="modal fade custom-modal " id="clearAllConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-header x-border py-1 pt-3">
                                <h1 class="px-1 display-6 fs-5">Clear All Students</h1>
                            </div>
                            <div class="modal-body x-border py-0">
                                <div class="d-flex gap-2justify-content-center align-items-center success-notice p-3">
                                    <div class="fs-1 text-success p-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="p-2 f-d">Notice! This will clear students with and without deficiencies. Are you sure you want to continue?</div>
                                </div>
                                <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                    <button id="clearAllConfirmModal" class="btn btn-success rounded confirm-remove">Yes</button>
                                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="default-border rounded-end mb-2 w-100 d-flex berow gap-3">
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
                    <table class="table display w-100 mb-2 table-hover text-center" id="my-datable">
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
                                    <td><?php if ($des_student['student_clearance_status'] == "1"){ echo '<div class=""><div class="badge-green"><i class="fas fa-check-circle i-dot i-success "></i> <span>Cleared</span></div></div>'; }else if($des_student['student_clearance_status'] == "2"){ echo '<div class=""><div class="badge-secondary"><i class="fas fa-star i-dot i-secondary "></i> <span>Unsigned</span></div></div>'; } else{ echo '<div class=""><div class="badge-danger"><i class="fas fa-exclamation-circle i-dot i-danger "></i> <span class="text-gray">Deficient</span></div></div>';}?></td>
                                    <td>
                                        <?php if($des_student['student_clearance_status'] == "1"): ?>
                                            <span data-bs-toggle="tooltip" title="Add Deficiency">
                                                <button data-id="<?php echo $des_student['student_id'] ?>" data-value="<?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] ?>" data-value1="<?php echo $des_student['year_level'] ?>" data-value2="<?php echo $des_student['program_course'] ?>" class="btn btn-sm btn-success rounded btnsm deficiency-btn" data-bs-toggle="modal" data-bs-target="#singleDeficiency"> <i class="fas fa-comment-plus"></i></button>
                                            </span>
                                            <span data-bs-toggle="tooltip" title="View Deficiency">
                                                <button data-id="<?php echo $des_student['student_id'] ?>" data-cl-id="<?php echo $_GET['clearance_id'] ?>" data-cl-table="<?php echo $_GET['designation_workplace'] ?>"  data-value="<?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] ?>" data-value1="<?php echo $des_student['year_level'] ?>" data-value2="<?php echo $des_student['program_course'] ?>" class="btn btn-sm btn-success rounded btnsm view-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"> <i class="fas fa-envelope"></i></button>
                                            </span>
                                            <!-- <button data-id="<?php echo $des_student['id'] ?>" class="btn btn-sm btn-success rounded btnsm clear-btn" <?php echo ($des_student['student_clearance_status'] == "1") ? 'disabled' : '' ; ?> ><i class="far fa-user-check"></i> Clear</button> -->
                                        <?php else: ?>
                                            <span data-bs-toggle="tooltip" title="Add Deficiency">
                                                <button data-id="<?php echo $des_student['student_id'] ?>" data-cl-id="<?php echo $_GET['clearance_id'] ?>" data-cl-table="<?php echo $_GET['designation_workplace'] ?>"  data-value="<?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] ?>" data-value1="<?php echo $des_student['year_level'] ?>" data-value2="<?php echo $des_student['program_course'] ?>" class="btn btn-sm btn-success rounded btnsm deficiency-btn" data-bs-toggle="modal" data-bs-target="#singleDeficiency"> <i class="fas fa-comment-plus"></i></button>
                                            </span>
                                            <span data-bs-toggle="tooltip" title="View Deficiency">
                                            <button data-id="<?php echo $des_student['student_id'] ?>" data-cl-id="<?php echo $_GET['clearance_id'] ?>" data-cl-table="<?php echo $_GET['designation_workplace'] ?>"  data-value="<?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] ?>" data-value1="<?php echo $des_student['year_level'] ?>" data-value2="<?php echo $des_student['program_course'] ?>" class="btn btn-sm btn-success rounded btnsm view-btn" data-bs-toggle="modal" data-bs-target="#viewMessage"> <i class="fas fa-envelope"></i></button>
                                            </span>
                                            
                                            <?php endif; ?>
                                            <span data-bs-toggle="tooltip" title="Clear Student">
                                                <button data-id="<?php echo $des_student['student_id'] ?>" data-cl-id="<?php echo $_GET['clearance_id'] ?>" data-cl-table="<?php echo $_GET['designation_workplace'] ?>" data-cl-workplace="<?php echo $_GET['workplace'] ?>" class="btn btn-sm btn-success rounded btnsm clear-btn" <?php echo ($des_student['student_clearance_status'] == "1") ? 'disabled' : '' ; ?> ><i class="fas fa-thumbs-up"></i></button>
                                            </span>
                                            <span class="" data-bs-toggle="tooltip" title="View Clearance">
                                                <button data-id="<?php echo $des_student['student_id'] ?>" data-value="<?php echo $_GET['clearance_id'] ?>" class="btn btn-view btn-sm btn-success rounded view-clearance" data-bs-toggle="modal" data-bs-target="#viewClearanceModal"><i class="fas fa-folder-open"></i></button>
                                            </span>

                                            
                                       
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                            
                    
                    </table>

                   <div class="mt-3">
                        <button id="printReport" class="btn btn-success rounded dis-btn" data-bs-toggle="tooltip" title="Print Student Clearance"><i class="fas fa-print me-1"></i> Print Report</button>
                        <button id="printDeficientReport" class="btn btn-success rounded dis-btn" data-bs-toggle="tooltip" title="Print Deficient Student"><i class="fas fa-print me-1"></i> Print Deficient</button>
                   </div>

                   <div class="modal fade" id="viewClearanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Student Clearance</h1>
                                </div>
                                <div id="studentClearanceData" class="h-100">

                                </div>
                                <div class="p-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="modal fade custom-modal" id="singleDeficiency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Input Message Deficiency</h1>
                                </div>
                                <div class="modal-body x-border py-0">
                                    <form class="px-3 pb-2" action="../controller/signatory_deficiency_single.php" method="post" enctype="multipart/form-data">
                                        
                                        <table class="table table-borderless w-auto">
                                            <tr>
                                                <td><span>Recipient:</span></td>
                                                <td><strong><i id="rec-text"></i></strong></td>
                                            </tr>
                                            <tr>
                                                <td><span>Name:</span></td>
                                                <td><strong><i id="name-text"></i></strong></td>
                                            </tr>
                                            <tr>
                                                <td><span>Course and Year:</span></td>
                                                <td><strong><i id="yc-text">Select Designation</i></strong></td>
                                            </tr>
                                            
                                        </table>

                                        <div class="input-cont mb-2">
                                            <textarea class="input-box" name="message" id="message" cols="30" rows="3" required></textarea>
                                            <label class="input-label">Input Message Deficiency</label>
                                        </div>
                                        
                                        <input type="hidden" name="student_id" id="student_id" value="">
                                        <input type="hidden" name="signatory_id" value="<?php echo $user_data['id']; ?>">
                                        <input type="hidden" name="clearance_id" value="<?php echo $_GET['clearance_id']; ?>">
                                        <input type="hidden" name="semester" value="<?php echo $clearanceInfo['semester'] ?>">
                                        <input type="hidden" name="academic_year" value="<?php echo $clearanceInfo['academic_year'] ?>">
                                        <input type="hidden" name="url_info_string" value="<?php echo 'clearance_id='. $_GET['clearance_id'] .'&workplace='. $_GET['workplace'] .'&designation_workplace= '. $_GET['designation_workplace'] ?>">
                                        <input type="hidden" name="designation_table" value="<?php echo $_GET['designation_workplace']; ?>">
                                        
                                            <div class="success-notice f-s my-3"><i class="fal fa-question-circle"></i> Note: This will add deficiencies to given student, please review your action before proceeding.</div>
                                       
                                        <div class="d-flex justify-content-end gap-2 pb-2">
                                            <button type="submit" class="btn btn-success rounded" name="submit">Send</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade custom-modal" id="viewMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Message Content</h1>
                                </div>
                                <div class="modal-body x-border py-0">
                                        
                                    <div class="default-border p-2 pt-2 mb-2">
                                        <table class="table table-borderless w-auto m-0">
                                            <tr>
                                                <td><span>To:</span></td>
                                                <td><strong><i id="m-rec-text"></i></strong></td>
                                            </tr>
                                            <tr>
                                                <td><span>Name:</span></td>
                                                <td><strong><i id="m-name-text"></i></strong></td>
                                            </tr>
                                            <tr>
                                                <td><span>Course and Year:</span></td>
                                                <td><strong><i id="m-yc-text">Select Designation</i></strong></td>
                                            </tr>
                                            
                                        </table>
                                    </div>

                                    
                                    <input type="hidden" name="student_id" id="m_student_id" value="">
                                    <input type="hidden" name="signatory_id" id="sigid" value="<?php echo $user_data['id']; ?>">
                                    <input type="hidden" name="clearance_id" value="<?php echo $_GET['clearance_id']; ?>">
                                    <input type="hidden" name="semester" value="<?php echo $clearanceInfo['semester'] ?>">
                                    <input type="hidden" name="academic_year" value="<?php echo $clearanceInfo['academic_year'] ?>">
                                    <input type="hidden" name="url_info_string" value="<?php echo 'clearance_id='. $_GET['clearance_id'] .'&workplace='. $_GET['workplace'] .'&designation_workplace= '. $_GET['designation_workplace'] ?>">
                                    <input type="hidden" name="designation_table" value="<?php echo $_GET['designation_workplace']; ?>">
                                    
                                    <div class="px-2" id="msg-area">
                                        
                                    </div>
                                    <!-- <div class="success-notice f-s my-3"><i class="fal fa-question-circle"></i> Note: This will add deficiencies to given student, please review your action before proceeding.</div> -->
                                    
                                    <div class="d-flex justify-content-end gap-2 mb-3 mt-1 px-2">
                                        <!-- <button type="submit" class="btn btn-success rounded" name="submit">Send</button> -->
                                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    
                                    <div class="py-2">
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
                $(document).ready(function(){

                    $('#my-datable tbody').on('click', '.deficiency-btn', function(){
                        let sid = $(this).attr('data-id');
                        let name = $(this).attr('data-value');
                        let yearLevel = $(this).attr('data-value1');
                        let programCourse = $(this).attr('data-value2');
                        $('#rec-text').text(sid);
                        $('#student_id').val(sid);
                        $('#name-text').text(name);
                        $('#yc-text').text(programCourse + " - " + yearLevel);
                        
                    });

                    $('#my-datable tbody').on('click', '.view-clearance', function(){
                        let student_id = $(this).attr('data-id');
                        let claerance_id = $(this).attr('data-value');
                        $.ajax({
                            type: "POST",
                            url: "../controller/clearance_admin_view.php",
                            data: {
                                student_id : student_id,
                                clearance_id : claerance_id,
                            },
                            success: function(result) {
                                console.log(result);
                                $('#studentClearanceData').html(result);
                            }
                        })
                    });

                    $('#submitDeficiencyBtn').on('click', function(){
                        let clearance_id =$(this).attr('data-id');
                        let designation_table = $(this).attr('data-value');
                        $.ajax({
                            type: "POST",
                            url: "../controller/signatory_submit_check.php",
                            data: {
                                clearance_id : clearance_id,
                                designation_table: designation_table,
                            },
                            success: function(result) {
                                let cstatus = JSON.parse(result);
                                if(cstatus.cs_status == "ended") {
                                    $('#submitDeficiencyBtn').prop('disabled', true);
                                }else {
                                    if(cstatus.cd_status == '1'){
                                        console.log('already been submited');
                                        $.ajax({
                                            type: "POST",
                                            url: "../controller/signatory_submit_cancel.php",
                                            data: {
                                                clearance_id : clearance_id,
                                                designation_table: designation_table,
                                                cd_id: cstatus.cd_id,
                                            },
                                            success: function(response) {
                                                $('#submitDeficiencyBtn').html("<i class='fas me-1 fa-thumbs-up'></i> Submit Deficiency");
                                                $("#submitDeficiencyBtn").removeClass("btn-danger");
                                                $("#submitDeficiencyBtn").addClass("btn-success");
                                                $('#imports').show();
                                            }
                                        })
                                    }else {
                                        $.ajax({
                                            type: "POST",
                                            url: "../controller/signatory_submit_deficiency.php",
                                            data: {
                                                clearance_id : clearance_id,
                                                designation_table: designation_table,
                                                cd_id: cstatus.cd_id,
                                            },
                                            success: function(response) {
                                                $('#submitDeficiencyBtn').text("Cancel");
                                                $("#submitDeficiencyBtn").removeClass("btn-success");
                                                $("#submitDeficiencyBtn").addClass("btn-danger");
                                                $('#imports').hide();
                                            }
                                        })

                                    }
                                    $('#submitDeficiencyBtn').prop('disabled', false);
                                }
                            }
                        })
                    })

                    $('#my-datable tbody').on('click', '.view-btn', function(){

                        let sid = $(this).attr('data-id');
                        let sigid = $('#sigid').val();
                        let cid = $(this).attr('data-cl-id');
                        let table = $(this).attr('data-cl-table');
                        let name = $(this).attr('data-value');
                        let yearLevel = $(this).attr('data-value1');
                        let programCourse = $(this).attr('data-value2');
                        $('#m-rec-text').text(sid);
                        $('#m_student_id').val(sid);
                        $('#m-name-text').text(name);
                        $('#m-yc-text').text(programCourse + " - " + yearLevel);

                        $.ajax({
                            type: "POST",
                            url: "../controller/signatory_deficiency_view.php",
                            data: {
                                student_id : sid,
                                clearance_id : cid,
                                designation_table: table,
                            },
                            success: function(result) {
                                console.log(result);
                                $('#msg-area').html(result);
                            }
                        })
                        
                    });

                    $('#my-datable tbody').on('click', '.clear-btn', function(){

                        let sid = $(this).attr('data-id');
                        let cid = $(this).attr('data-cl-id');
                        let workplace = $(this).attr('data-cl-workplace');
                        let table = $(this).attr('data-cl-table');
                        let url_string = "clearance_id=" + cid + "&workplace=" + workplace + "&designation_workplace=" + table; 
                        let url_info_string = url_string.replace(/\s+/g, '');

                        $.ajax({
                            type: "POST",
                            url: "../controller/signatory_deficiency_clear.php",
                            data: {
                                student_id : sid,
                                clearance_id : cid,
                                signatory_id : sid,
                                workplace: workplace,
                                designation_table: table,
                            },
                            success: function(result) {
                                console.log(result);
                                window.location.replace("clearance_signatory_designation.php?" + url_info_string);
                            }
                        })
                    });

                    $('#clearAllBtn').on('click', function(){
                        let cid = $(this).attr('data-id');
                        let table = $(this).attr('data-value');

                        $('#clearAllConfirmModal').attr('data-id', cid);
                        $('#clearAllConfirmModal').attr('data-value', table);

                    });

                    $('#clearAllConfirmModal').on('click', function(){
                        let cid = $(this).attr('data-id');
                        let table = $(this).attr('data-value');
                        let workplace = '<?php echo $_GET['workplace']; ?>';

                        let url_string = "clearance_id=" + cid + "&workplace=" + workplace + "&designation_workplace=" + table; 
                        let url_info_string = url_string.replace(/\s+/g, '');

                        $.ajax({
                            type: "POST",
                            url: "../controller/signatory_deficiency_clear_all.php",
                            data: {
                                clearance_id : cid,
                                designation_table: table,
                            },
                            success: function(result) {
                                window.location.replace("clearance_signatory_designation.php?" + url_info_string + "&clear_all=success");
                            }
                        })
                    });

                    $('#printReport').click(function() {
                        let clearance_id = '<?php echo $_GET['clearance_id']; ?>';
                        let designation_table = '<?php echo $_GET['designation_workplace']; ?>';
                        $.ajax({
                            url: 'student_clearance_report.php',
                            type: "GET",
                            data: {clearance_id: clearance_id,
                                   designation_table: designation_table
                                },
                            success: function(response) {
                                // Create a new window and write the response content to it
                                let printWindow = window.open('', 'Print Window');
                                printWindow.document.write(response);

                                // Wait for the new window to finish loading before calling the print() function
                                
                                setTimeout(function(){
                                    printWindow.print();
                                    // Close the new window
                                    printWindow.close();
                                }, 1000);
                            }
                        });
                    });

                    $('#printDeficientReport').click(function() {
                        let clearance_id = '<?php echo $_GET['clearance_id']; ?>';
                        let designation_table = '<?php echo $_GET['designation_workplace']; ?>';
                        $.ajax({
                            url: 'student_deficient_report.php',
                            type: "GET",
                            data: {clearance_id: clearance_id,
                                   designation_table: designation_table
                                },
                            success: function(response) {
                                // Create a new window and write the response content to it
                                let printWindow = window.open('', 'Print Window');
                                printWindow.document.write(response);

                                // Wait for the new window to finish loading before calling the print() function
                                
                                setTimeout(function(){
                                    printWindow.print();
                                    // Close the new window
                                    printWindow.close();
                                }, 1000);
                            }
                        });
                    });

                })
               
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>