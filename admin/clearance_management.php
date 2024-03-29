<?php 
    require_once '../includes/main_header.php'; 

    $clearanceTypes = $clearance->getClearanceType();
    $clearances = $clearance->getAllClearance();
    $beneficiaries = $clearance->getBeneficiaries();
    $user_data = $_SESSION['user_data'];
    $current_year = date('Y');
    $prev_year = $current_year - 1;
    $next_year = date('Y', strtotime($current_year . ' +1 year'));

?>
    <div class="page position-relative">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Clearance Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/clearance_create.php" method="POST">
                        <label class="form-label">Manage Clearances</label>
                        <div class="p-1 px-3">
                            <div class="mb-2">
                                <div class="custom-select select-clearance-beneficiaries">
                                    <input type="hidden" class="select-name" name="clearance_beneficiary" id="clearance_beneficiary">
                                    <button type="button" class="select-btn"> 
                                        <span class="sbtn-text" id="crtext">Clearance Recipient</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Clearance Recipient</li>
                                            <?php while($beneficiary = $beneficiaries->fetch(PDO::FETCH_ASSOC)): ?>
                                                <li data-value="<?php echo $beneficiary['id'] ?>"><?php echo $beneficiary['beneficiary'] ?></li>
                                            <?php endwhile; ?>
                                    </ul>
                                </div>
                           </div>
                           <div class="mb-2">
                                <div class="custom-select select-clearance-type">
                                    <input type="hidden" class="select-name" name="clearance_type" id="clearance_type">
                                    <button type="button" class="select-btn"> 
                                        <span class="sbtn-text" id="cttext">Clearance Type</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Clearance Type</li>
                                            <?php while($ct_row = $clearanceTypes->fetch(PDO::FETCH_ASSOC)): ?>
                                                <li data-value="<?php echo $ct_row['id'] ?>"><?php echo $ct_row['clearance_name'] ?></li>
                                            <?php endwhile; ?>
                                    </ul>
                                </div>
                           </div>
                           <div class="d-flex gap-3 mb-2 p-2">
                                <div class="custom-radio">
                                    <input class="rd-button" type="radio" name="semester" value="1st Semester" id="semester">
                                    <span class="rd-text">1st Semester</span>
                                </div>
                                <div class="custom-radio">
                                    <input class="rd-button" type="radio" name="semester" value="2nd Semester" id="semester">
                                    <span class="rd-text">2nd Semester</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="custom-select select-academic-year">
                                    <input type="hidden" class="select-name" name="academic_year" id="academic_year">
                                    <button type="button" class="select-btn"> 
                                        <span class="sbtn-text" id="aytext">Academic Year</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Academic Year</li>
                                        <li data-value="2022-2023"><?php echo $prev_year ?>-<?php echo $current_year ?></li>
                                        <li data-value="2023-2024"><?php echo $current_year ?>-<?php echo $next_year ?></li>
                                    </ul>
                                </div>
                           </div>
                           <button id="preAddBtn" type="button" class="btn btn-success rounded mt-3" data-bs-toggle="modal" data-bs-target="#confirmAddClearance">Create Clearance</button>           
                            <!-- <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="clearanceBtn">Create Clearance</button> -->
                        </div>

                        <div class="modal fade custom-modal" id="confirmAddClearance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Clearance Information</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        
                                        <div>
                                            
                                            <div class="default-border py-2 px-3">
                                                
                                                <table class="table table-borderless w-auto mt-1">
                                                    <tr>
                                                        <td><span>Clearance Recipient:</span></td>
                                                        <td><strong><i id="cr-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Clearance Type:</span></td>
                                                        <td><strong><i id="ct-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Semester:</span></td>
                                                        <td><strong><i id="sem-text">Select Designation</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Academic Year:</span></td>
                                                        <td><strong><i id="ay-text">Select Designation</i></strong></td>
                                                    </tr>
                                                    
                                                </table>
                                                
                                            </div>
                                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <!-- <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div> -->
                                            <div class="warning-notice f-d mt-3 my-2"> <i class="fas fa-exclamation-triangle text-danger"></i> Notice! Please check all the information you've entered before proceeding, once it was added, it cannot be edited.</div>
                                            
                                        </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button type="submit" name="submit" class="btn btn-success rounded" id="clearanceBtn">Create Clearance</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <div class="d-flex justify-content-between align-items-end mb-2 ">
                        <label class="form-label">Clearance Records</label>
                        <div class="form-group d-flex gap-2">
                            <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                            <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                        </div>
                    </div> 
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>Clearance</th>
                                    <th>Recipient</th>
                                    <th>Semester</th>
                                    <th>Academic Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <?php $count = 1; while($c_row = $clearances->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><div class="td-label"><?php echo $c_row['clearance_name'] ?></div></td>
                                        <td><div class="td-label"><?php echo (in_array($c_row['clearance_beneficiary'], array("1","2","3")) ) ? $clearance->getBeneficiary($c_row['clearance_beneficiary']) : $c_row['clearance_beneficiary']; ?></div></td>
                                        <td><div class="td-label"><?php echo $c_row['semester'] ?></div></td>
                                        <td><div class="td-label"><?php echo $c_row['academic_year'] ?></div></td>
                                        <td>
                                            <button data-id="<?php echo $c_row['clearance_id']?>" class="btn btn-delete btn-sm btn-danger rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash me-1"></i> Delete</button>
                                            <button data-id="<?php echo $c_row['clearance_id'] ?>" class="btn btn-sm btn-success rounded btnsm status-btn" data-bs-toggle="modal" data-bs-target="#clearanceDashboard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clearance Status" data-bs-custom-class="custom-tooltip"><i class="fas fs-6 fa-sliders-h"></i></button>
                                        </td>
                                    </tr>

                                <?php $count++; endwhile; ?>
                        
                        </table>

                        
                        <div class="modal fade custom-modal modal-dashboard modal-lg" id="clearanceDashboard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3 d-flex justify-content-between align-items-center mb-1">
                                        <h1 class="px-1 display-6 fs-5 mb-0">Clearance Status</h1>
                                        <div class="f-d badge bg-success " data-bs-toggle="tooltip" title="Clearance Reference Number">CRN <span id="crn"></span></div>
                                    </div>
                                        <div class="modal-body x-border py-0">
                                    
                                        <!-- <div id="search-list">
                                            <table class="table">
                                                <th>ID</th>
                                                <th>Recipient</th>
                                                <th>Semester</th>
                                                <th>Academic Year</th>
                                                <th>Status</th>
                                            </table>
                                        </div> -->
                                        <div class="d-flex gap-3 justify-content-center cdash-table-data">
                                            <div class="order-1"> 
                                                <h1 class="fs-6 mb-2">Submission Status</h1>
                                                <div class="d-flex gap-2 justify-content-center mb-3">
                                                    <div class="bg-white px-3 py-2 flex-column rounded d-flex justify-content-center align-items-center default-border">
                                                        <h1 class="display-6 f-d m-0">Signatories</h1>
                                                        <h1 class="fs-4 m-0 text-accent" id="submission">15</h1>
                                                    </div>
                                                    <div class="bg-white px-3 py-2 flex-column rounded d-flex justify-content-center align-items-center default-border">
                                                        <h1 class="display-6 f-d m-0">Submitted</h1>
                                                        <h1 class="fs-4 m-0 text-accent" id="submitted">15</h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start">
                                                    <div class="form-group d-flex gap-2">
                                                        <input class="form-control form-control-sm" type="text" id="tb-val" placeholder="Search...">
                                                        <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                                                    </div>
                                                </div> 
                                                <table class="table text-center table-bordered py-3 pt-1 w-100 mt-0" id="submitTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Workplace</th>
                                                            <th>Designation</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="default-border py-2 px-3 flex-grow-1 order-0">
                                                
                                                <table class="table table-borderless w-auto mt-1">
                                                    <tr>
                                                        <td><span>Clearance Recipient:</span></td>
                                                        <td><strong><i id="c-cr-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Clearance Type:</span></td>
                                                        <td><strong><i id="c-ct-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Semester:</span></td>
                                                        <td><strong><i id="c-sem-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Academic Year:</span></td>
                                                        <td><strong><i id="c-ay-text"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Date Created:</span></td>
                                                        <td><strong><i id="c-created"></i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Date Deployed Signatories:</span></td>
                                                        <td><strong><i id="c-deployed">-</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Date Deployed Student:</span></td>
                                                        <td><strong><i id="c-deployed-stud">-</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Date Ended:</span></td>
                                                        <td><strong><i id="c-ended">-</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Status:</span></td>
                                                        <td id="c-status"><strong class="badge-green text-success"><i>-</i></strong></td>
                                                    </tr>
                                                </table>

                                                
                                                
                                            </div>
                                        </div>
                                            
                                        
                                        <div class="d-flex my-2 mb-3 gap-2 align-items-end">
                                                <div class="d-flex flex-wrap gap-2 cdash-controls">
                                                   <div>
                                                        <div class="f-d display-6 m-1">Step 1</div>
                                                        <button id="deploySignatoryBtn" class="btn btn-success rounded dis-btn">Deploy to Signatories</button>
                                                   </div>
                                                   <div>
                                                        <div class="f-d display-6 m-1">Step 2</div>
                                                        <button id="deployStudentBtn" class="btn btn-success rounded dis-btn">Deploy to Students</button>
                                                   </div>
                                                   <div>
                                                        <div class="f-d display-6 m-1">Step 3</div>
                                                        <button id="endClearanceBtn" class="btn btn-danger rounded dis-btn">End</button>
                                                   </div>
                                                </div>
                                           <div class="ms-auto d-flex gap-2 berow">
                                                <button id="viewClearanceBtn" type="button" class="btn btn-success rounded dis-btn fs-5" data-bs-toggle="tooltip" title="View Student Clearance"><i class="fas fa-external-link"></i></button>
                                                <button id="printReport" class="btn btn-success rounded dis-btn fs-5" data-bs-toggle="tooltip" title="Print Student Clearance"><i class="fas fa-print"></i></button>
                                                <button type="button" class="btn btn-secondary rounded ms-auto" data-bs-dismiss="modal">Cancel</button>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade custom-modal " id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Delete Clearance</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to delete this clearance?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="clearanceDelete" class="btn btn-danger rounded confirm-delete">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                    </div>
                </div>
            </div>

            <script>      

                $(document).ready(function(){
                    setTimeout(function(){
                        $('#err').remove();
                    },3000);

                    $('#preAddBtn').click(function(){
                        let crText = $('#crtext').text();
                        let ctText = $('#cttext').text();
                        let semText = $('input[name="semester"]').val();
                        let ayText = $('#aytext').text();

                        $('#cr-text').text(crText);
                        $('#ct-text').text(ctText);
                        $('#sem-text').text(semText);
                        $('#ay-text').text(ayText);
                     
                    })

                    var id;

                    $('#my-datable tbody').on('click', '.edit-btn', function(){
                        id = $(this).attr('data-id')
                        $.ajax({
                            type: "GET",
                            url: "../controller/sign_edit.php",
                            data: {
                                id : id,
                            },
                            success: function(result) {
                                $('#addSignatory').text("Save Changes");
                                let sign_info = JSON.parse(result);
                                
                                $('#firstname').val(sign_info.first_name)
                                $('#middlename').val(sign_info.middle_name)
                                $('#lastname').val(sign_info.last_name)
                                $('#email').val(sign_info.email)
                                
                                $('#addSignatory').attr('type', 'button')
                            }
                        })
                    })

                    $('#addSignatory').click(function(){
                        if($(this).attr('type') === 'button') {
                            saveChanges();
                        }
                    })

                    function saveChanges() {
                        let firstname = $('#firstname').val()
                        let middlename = $('#middlename').val()
                        let lastname = $('#lastname').val()
                        let email = $('#email').val()
                        
                        
                        if(firstname.length !== 0 || middlename.length !== 0 || lastname.length !== 0 || email.length !== 0) {
                            $.ajax({
                                method : "POST",
                                url: "../controller/sign_update.php",
                                data: {
                                    id : id,
                                    first_name: firstname,
                                    middle_name: middlename,
                                    last_name: lastname,
                                    email: email,
                                },
                                success: function(result) {
                                    window.location.replace('signatory_management.php?update=success');
                                }
                            })
                        }else {
                            $('#err').remove();
                            $('.page-content').before('<div class="alert alert-primary" id="err">There was missing inputs.</div>');
                            setTimeout(function(){
                                $('#err').remove();
                            },3000)
                        }

                    }

                    
                    $('#my-datable tbody').on('click', '.btn-delete', function(){
                        let idDelete = $(this).attr('data-id');
                        $('#clearanceDelete').attr('data-id', idDelete);
                    });

                    $('#clearanceDelete').click(function() {
                        let idDelete = $(this).attr('data-id');
                        $('#deleteModal').modal('hide');
                        window.location.replace("../controller/clearance_delete.php?id=" + idDelete);
                    });

                    var clearance_data;
                    var clearance_id;

                    let dashtable = $('#submitTable').DataTable({
                            
                            "pageLength": 9,
                            "bPaginate": false,
                            responsive: true,
                            "targets": 'no-sort',
                            "bSort": true,
                            "order": [],
                            "bInfo": false,
                        });

                    $('#tb-val').on('keyup', function() {
                        dashtable.search($('#tb-val').val()).draw()
                    });
                    
                    $('#my-datable tbody').on('click', '.status-btn', function(){
                        dashtable.clear().draw();
                        clearance_id = $(this).attr('data-id');
                        $('#crn').text(clearance_id);

                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_check_status.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function (response){
                                let result = JSON.parse(response);
                                let bid = result.clearance_info.clearance_beneficiary;
                                clearClearanceText();
                                
                                var number = 0;
                                for(let i = 0; i < 5; i++) {
                                    if(i == bid){
                                        $.ajax({
                                            type: "POST",
                                            url: "../controller/clearance_get_beneficiary.php",
                                            data: {
                                                key : "hellow",
                                                id: bid,
                                            },
                                            success: function(res) {
                                                $('#c-cr-text').text(res);
                                            }
                                        })
                                        break;
                                    }
                                    number++;
                                }

                                if(number == 5) {
                                    $('#c-cr-text').text(bid);
                                }
                               

                              
                                $('#c-ct-text').text(result.clearance_info.clearance_name);
                                $('#c-sem-text').text(result.clearance_info.semester);
                                $('#c-ay-text').text(result.clearance_info.academic_year);
                               

                                let created = new Date(result.clearance_info.date_created);
                                $('#c-created').text($.format.date(created, "MMM d, yyyy") + " At " + $.format.date(created, "h:mm a"));
                                $('#endClearanceBtn').prop('disabled', true);
                                if(result.returned_row > 0){
                                    let deployed = new Date(result.returned_data.date_deploy_signatory);
                                    if(result.returned_data.date_deploy_signatory !== "") {
                                        $('#c-deployed').text($.format.date(deployed, "MMM d, yyyy") + " At " + $.format.date(deployed, "h:mm a"));
                                        $('#c-status').html('<strong class="badge-green text-success"><i>Deployed</i></strong>');
                                    }else {
                                        $('#c-status').html('<strong class="badge-primary text-primary"><i>Initialized</i></strong>');
                                    }
                                    let deployed_stud = new Date(result.returned_data.date_deploy_student);
                                    if(result.returned_data.date_deploy_student !== "") {
                                        $('#c-deployed-stud').text($.format.date(deployed_stud, "MMM d, yyyy") + " At " + $.format.date(deployed_stud, "h:mm a"));
                                        $('#deploySignatoryBtn').prop('disabled', true);
                                        $('#deployStudentBtn').prop('disabled', true);
                                        $('#endClearanceBtn').prop('disabled', false);
                                    }else {
                                        $('#deployStudentBtn').prop('disabled', false);
                                    }
                                    let ended = new Date(result.returned_data.date_ended);
                                    if(result.returned_data.date_ended !== "") {
                                        $('#c-ended').text($.format.date(ended, "MMM d, yyyy") + " At " + $.format.date(ended, "h:mm a"));
                                        $('#c-status').html('<strong class="badge-danger text-danger"><i>Ended</i></strong>');
                                        $('#deploySignatoryBtn').prop('disabled', true);
                                        $('#deployStudentBtn').prop('disabled', true);
                                        $('#endClearanceBtn').prop('disabled', true);
                                    }
                                    // let ended = new Date(result.clearance_info.date_created);
                                    $('#deploySignatoryBtn').prop('disabled', true);
                                    
                                }else {
                                    $('#deploySignatoryBtn').prop('disabled', false);  
                                    $('#deployStudentBtn').prop('disabled', true);
                                    $('#endClearanceBtn').prop('disabled', true);
                                }

                                // $.ajax({
                                //     type: "POST",
                                //     url: "../controller/clearance_get_beneficiary.php",
                                //     data: {
                                //         ket: "Key",
                                //         id : bid
                                //     },
                                //     dataType: "json",
                                //     success: function(res) {
                                //         console.log(res);
                                //         // let cb = JSON.parse(res);
                                //         // $('#c-cr-text').text(cb.beneficiary);
                                //     }
                                // })
                            }
                        })

                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_submit_status.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function(result) {
                                let submitData = JSON.parse(result)
                                // console.log(submitData)
                                $('#submission').text(submitData.count);

                                let submittedCount = 0;
                                $.each(submitData.submission, function(index, value){

                                    let cd_status = value.cd_status;
                                    if(cd_status == '1'){
                                        cd_status = "<i class='fa-solid fa-check text-success'></i>";
                                        submittedCount += 1;
                                    }else{
                                        cd_status = "<i class='fa-solid fa-xmark text-danger'></i>";
                                    }

                                    let signatory_id = value.signatory_id;
                                    let workplace = value.signatory_workplace_name;

                                    $.ajax({
                                        method : "POST",
                                        url: "../controller/clearance_submitsig_info.php",
                                        data: {
                                            signatory_id : signatory_id,
                                            workplace : workplace,
                                        },
                                        success: function(result) {

                                            var newRow = [
                                                value.signatory_workplace_name,
                                                JSON.parse(result),
                                                cd_status
                                            ];
                                            dashtable.row.add(newRow).draw(false);

                                            // $("#submitTable tbody").append("<tr><td>" + value.signatory_workplace_name + "</td><td>" + JSON.parse(result) + "</td><td>" + cd_status + "</td></tr>");
                                        }
                                    })
                                })
                                $('#submitted').text(submittedCount);
                            }
                        })

                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_get_info.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function(result) {
                                clearance_data = JSON.parse(result)
                            }
                        })

                        function clearClearanceText() {
                            $('#c-cr-text').text('');
                            $('#c-ct-text').text('');
                            $('#c-sem-text').text('');
                            $('#c-ay-text').text('');
                            $('#c-deployed').text('-');
                            $('#c-deployed-stud').text('-');
                            $('#c-ended').text('-');
                            $('#c-status').html('<strong class="badge-primary text-primary"><i>Initialized</i></strong>');
                    }
                    

                    });


                    $('#deploySignatoryBtn').click(function(){
                        let beneficiary = clearance_data.clearance_beneficiary;
                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_deploy_signatories.php",
                            data: {
                                id : clearance_id,
                                clearance_beneficiary: clearance_data.clearance_beneficiary,
                                clearance_type: clearance_data.clearance_type,
                                semester: clearance_data.semester,
                                academic_year: clearance_data.academic_year,
                            },
                            success: function(response) {
                                console.log(response);
                                $('#deploySignatoryBtn').prop('disabled', true);
                                $('#deployStudentBtn').prop('disabled', false);
                            }
                        });
                    }); 

                    $('#deployStudentBtn').click(function(){
                        let beneficiary = clearance_data.clearance_beneficiary;

                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_submit_status.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function(response) {
                                let submissionStatus = JSON.parse(response);

                                let submittedCount = 0;
                                $.each(submissionStatus.submission, function(index, value){

                                    let cd_status = value.cd_status;
                                    if(cd_status == '1'){
                                        submittedCount += 1;
                                    }
                                })

                                console.log(submittedCount);

                                if(submittedCount < submissionStatus.count){
                                    $('.page').prepend('<div class="popup-message"><div class="alert alert-danger shadow-xl" role="alert">Signatories are not yet submitting!</div>');
                                    $('.popup-message').animate({opacity: 1}, 800)
                                    setTimeout(function(){
                                        $('.popup-message').animate({opacity: 0}, 800, function() {
                                            $(this).remove();
                                        });
                                    },3000);
                                }else{
                                    $.ajax({
                                        method : "POST",
                                        url: "../controller/clearance_deploy_student.php",
                                        data: {
                                            id : clearance_id,
                                        },
                                        success: function(response) {
                                            console.log(response);
                                            $('#deploySignatoryBtn').prop('disabled', true);
                                            $('#deployStudentBtn').prop('disabled', true);
                                            $('#endClearanceBtn').prop('disabled', false);
                                        }
                                    });

                                    $.ajax({
                                        method : "POST",
                                        url: "../controller/clearance_record_student.php",
                                        data: {
                                            id : clearance_id,
                                        },
                                        success: function(response) {
                                            console.log(response);
                                        }
                                    });
                                }
                                
                            }
                        });



                       

                        
                    }); 

                    $('#endClearanceBtn').click(function(){
                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_end.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function(response) {
                                 console.log(response);
                                $('#endClearanceBtn').prop('disabled', true);
                            }
                        });
                    });

                    $('#printReport').click(function() {
                        console.log(clearance_id);
                        $.ajax({
                            url: 'student_clearance_report.php',
                            type: "GET",
                            data: {clearance_id: clearance_id},
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

                    $('#viewClearanceBtn').click(function(){
                        window.location.replace('student_clearance_record.php?clearance_id='+ clearance_id);
                    });

                   

                    function loadinAnimation() {
                        let html = "";
                        
                        html += "<div class='d-flex justify-content-center align-items-center gap-2'>"
                        html += '<div class="spinner-border spinner-border-sm text-success text-center" role="status"><span class="visually-hidden"></span></div><div><span class="text-success">Loading...</span></div>';
                        html += "</div>"
                        return html;
                       
                    }

                    //reinitiallized of custom-select
                    var customSelectList = document.querySelectorAll(".custom-select");
                    function initializeCustomSelect() {
                        
                        // Re-initialize the custom-select plugin for all dropdowns on the page
                        customSelectList.forEach(function(customSelect) {
                        const selectOptions = customSelect.querySelectorAll(".select-menu li");
                        const hiddenInput = customSelect.querySelector('.select-name');
                        const selectBtnText = customSelect.querySelector(".sbtn-text");
                    
                        selectOptions.forEach(function(option) {
                            option.addEventListener("click", function() {
                            const selectValue = option.dataset.value;
                            const selectedText = option.textContent;
                    
                            hiddenInput.value = selectValue;
                            selectBtnText.textContent = selectedText;
                            customSelect.classList.remove("active");
                            });
                        });
                        });
                    } 

                    // function emptySelection() {
                    //     $("#category").val("");
                    //     $("#workplace").val("");
                    //     $("#category").val("");
                    // }
                  
                });
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>