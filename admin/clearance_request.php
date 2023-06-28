<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';


    $clearanceTypes = $clearance->getClearanceType();
    $clearances = $clearance->getAllClearance();
    $beneficiaries = $clearance->getBeneficiaries();

    $current_year = date('Y');
    $prev_year = $current_year - 1;
    $next_year = date('Y', strtotime($current_year . ' +1 year'));

    $user_data = $_SESSION['user_data'];
    $availableClearance = $request->getAvailableForRequest();

    $request_record = $request->getAllRequestRecord();
?>
    <div class="page">
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Request Clearance</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                <div class="col-lg-5 pt-2 d-none">
                    <label class="form-label">Request Information</label>
                    <form action="../controller/request_send.php" method="POST">
                        <div class="p-1">
                            <div class="mb-3">
                                <input type="hidden" name="student_id" value="<?php echo $user_data['student_id'] ?>">
                                <div class="custom-select select-clearance-type">
                                    <input type="hidden" class="select-name" name="clearance_type" id="clearance_type" required>
                                    <button type="button" class="select-btn"> 
                                        <span class="sbtn-text" id="cttext">Clearance Type</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Clearance Type</li>
                                        <?php while($req_row = $availableClearance->fetch(PDO::FETCH_ASSOC)): ?>
                                                <li data-value="<?php echo $req_row['id'] ?>"><?php echo $req_row['clearance_name'] ?></li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="input-cont">
                                <textarea class="input-box" required name="request_reason" id="" cols="30" rows="10" required></textarea>
                                <label class="input-label">Reason for request</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success rounded mt-3">Send Request </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 pt-2 px-4">
                    <label class="form-label">Request List</label>
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Education</th>
                                    <th>Program</th>
                                    <th>Academic</th>
                                    <th>Requested Clearance</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                               
                                <?php $count = 1; while($rec_row = $request_record->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $rec_row['student_id'] ?></td>
                                        <td><?php echo $rec_row['last_name'] . ", " . $rec_row['first_name'] . " " . $rec_row['middle_name'] //strtoupper(substr($stud_row['middle_name'], 0, 1)) ."." ?></td>
                                        <td><?php echo $rec_row['academic_level'] ?></td>
                                        <td><?php echo $rec_row['program_course'] ?></td>
                                        <td>
                                            <?php 
                                                switch($rec_row['year_level']){
                                                    case '1' : 
                                                        echo $rec_row['year_level'] . "st Year";
                                                    break ;
                                                    case '2' : 
                                                        echo $rec_row['year_level'] . "nd Year";
                                                    break ;
                                                    case '3' : 
                                                        echo $rec_row['year_level'] . "rd Year";
                                                    break ;
                                                    case '4' : 
                                                        echo $rec_row['year_level'] . "th Year";
                                                    break ;
                                                    default:
                                                        echo 'Grade ' . $rec_row['year_level'];
                                                    break ;
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $rec_row['clearance_name'] ?></td>
                                        <td><?php if($rec_row['request_status'] == "issued"){ echo '<div class="d-flex justify-content-center"><div class="badge-green"><i class="fas fa-circle i-dot i-success "></i> <span>Issued</span></div></div>';}else if($rec_row['request_status'] == 'pending'){ echo '<div class="d-flex justify-content-center"><div class="badge-primary"><i class="fas fa-circle i-dot i-primary "></i> <span>Pending</span></div></div>';}else if($rec_row['request_status'] == "rejected"){ echo '<div class="d-flex justify-content-center"><div class="badge-danger"><i class="fas fa-circle i-dot i-danger "></i> <span>Rejected</span></div></div>';} ?></td>
                                        <td>
                                            <button data-id="<?php echo $rec_row['request_id'] ?>" data-value="<?php echo $rec_row['student_id'] ?>" class="btn btn-sm btn-primary rounded small-btn request-btn " data-bs-toggle="modal" data-bs-target="#requestInfo"><i class="fas fa-envelope" ></i> View</button>
                                            <button data-id="<?php echo $rec_row['request_id'] ?>" data-value="<?php echo $rec_row['student_id'] ?>" class="btn btn-sm btn-success rounded small-btn issue-btn " data-bs-toggle="modal" data-bs-target="#issueInfo" <?php if($rec_row['request_status'] == 'issued' || $rec_row['request_status'] == "rejected"){echo 'disabled';} ?>><i class="fas fa-paper-plane"></i> Issue</button>
                                            <button data-id="<?php echo $rec_row['request_id'] ?>" data-value="<?php echo $rec_row['student_id'] ?>" class="btn cancel-btn btn-sm btn-danger rounded small-btn dsb-btn <?php echo ($rec_row['request_status'] == "rejected" || $rec_row['request_status'] == "issued" ) ? "not-allowed" :"" ; ?>" data-bs-toggle="modal" data-bs-target="#cancelModal" <?php if($rec_row['request_status'] == 'issued' || $rec_row['request_status'] == "rejected"){echo 'disabled';} ?>><i class="fas fa-trash"></i> Reject</button>
                                        </td>
                                    </tr>
                                <?php $count++; endwhile; ?> 
                               

                        </table>
                    
                        <div class="modal fade custom-modal " id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Cancel Request</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to cancel this request?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="removeSignatory" class="btn btn-danger rounded confirm-cancel">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade custom-modal " id="issueInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content ">
                        <div class="modal-header x-border py-1 pt-3">
                            <h1 class="px-1 display-6 fs-5">Transferring Clearance</h1>
                        </div>
                        <div class="modal-body x-border py-0">
                        <div>
                                            
                            <div class="default-border py-2 px-3">
                                
                                <table class="table table-borderless w-auto mt-1">
                                    <tr>
                                        <td><span>Clearance Recipient:</span></td>
                                        <td><strong><i id="cr-text">Student ID</i></strong></td>
                                    </tr>
                                    <tr>
                                        <td><span>Clearance Type:</span></td>
                                        <td><strong><i id="ct-text">Clearance Type</i></strong></td>
                                    </tr>
                                    <tr>
                                        <td><span>Semester:</span></td>
                                        <td>
                                            <select name="semester" id="semester" class="form-select form-select-sm">
                                                <option value="1st Semester">1st Semester</option>
                                                <option value="2nd Semester">2nd Semester</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>Academic Year:</span></td>
                                        <td>
                                            <select name="academic_year" id="academic_year" class="form-select form-select-sm">
                                                <option value="<?php echo $prev_year ?>-<?php echo $current_year ?>"><?php echo $prev_year ?>-<?php echo $current_year ?></option>
                                                <option value="<?php echo $current_year ?>-<?php echo $next_year ?>"><?php echo $current_year ?>-<?php echo $next_year ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                </table>
                                
                            </div>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                            <!-- <div class="fs-1 text-danger p-2">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div> -->
                            <div class="danger-notice f-d mt-3 my-2"> <i class="fas fa-exclamation-triangle text-danger"></i> Notice! Please check all the information you've entered before proceeding, once it was added, it cannot be edited.</div>
                            
                        </div>
                        </div>
                            <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                <button id="continueBtn" class="btn btn-success rounded continue-btn">Continue</button>
                                <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade custom-modal" id="requestInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-light">
                        <div class="modal-header x-border py-1 pt-3">
                        </div>
                        <div class="modal-body x-border py-0">
                                
                            <div class="px-2" id="msg-area">
                                
                            </div>
                
                            
                            <div class="d-flex justify-content-end gap-2 mb-3 mt-1 px-2">
                                <!-- <button type="submit" class="btn btn-success rounded" name="submit">Send</button> -->
                                <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>  
            <script>
                $(document).ready(function(){
                    var editId;

                    setTimeout(function(){
                        $('#err').remove();
                    },3000)

                    $("button[disabled]").hover(function() {
                        $(this).addClass("not-allowed");
                    }, function() {
                        $(this).removeClass("not-allowed");
                    });
                    
                    $('#addOrgBtn').click( function (){
                        btnStatus = $(this).text();
                        if(btnStatus === "Add Organization") {
                            addOrganization();
                        }else if (btnStatus === "Save Changes") {
                            saveChanges();
                        }
                    })

                    $('#my-datable tbody').on('click', '.edit-btn', function(){
                        editId = $(this).attr('data-id');
                        $.ajax({
                            type: "GET",
                            url: "../controller/org_edit.php",
                            data: {
                                id : editId,
                            },
                            success: function(result) {
                                $('#addOrgBtn').text("Save Changes");
                                let org_info = JSON.parse(result);
                                $('#organization_code').val(org_info.organization_code)
                                $('#organization_name').val(org_info.organization_name)
                            }
                        })
                    })

                    var request_id;
                    var student_id;

                    $('#my-datable tbody').on('click', '.issue-btn', function(){
                        request_id = $(this).attr('data-id');
                        student_id = $(this).attr('data-value');
                        $('#cr-text').text(student_id);
                        $('#ct-text').text("Transferring Clearance");
                    })

                    $('#continueBtn').on('click', function(){
                        let academic_year = $('#academic_year').val();
                        let semester = $('#semester').val();

                        $.ajax({
                            type: "POST",
                            url: "../controller/request_issue.php",
                            data: {
                                request_id : request_id,
                                student_id: student_id,
                                academic_year: academic_year,
                                semester: semester
                            },
                            success: function(result) {
                                console.log(result);
                               window.location.replace('clearance_request.php?issue=success');
                            }
                        })
                    })

                    function saveChanges() {
                        let orgCode = $('#organization_code').val()
                        let orgName = $('#organization_name').val()
                        
                        if(orgCode.length !== 0 || orgName.length !== 0) {
                            $.ajax({
                                method : "POST",
                                url: "../controller/org_update.php",
                                data: {
                                    id : editId,
                                    organization_code: orgCode,
                                    organization_name: orgName,
                                },
                                success: function(result) {
                                    window.location.replace('org_management.php?update=success');
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

                    $('#my-datable tbody').on('click', '.request-btn', function(){
                        let id = $(this).attr('data-id');
                        let student_id = $(this).attr('data-value');
                        $.ajax({
                                method : "POST",
                                url: "../controller/request_view.php",
                                data: {
                                    request_id : id,
                                    student_id : student_id
                                },
                                success: function(result) {
                                    $('#msg-area').html(result);
                                }
                            })

                    });

                    $('#my-datable tbody').on('click', '.cancel-btn', function(){
                        let id = $(this).attr('data-id');
                        $('.confirm-cancel').attr('data-id',id);
                    });

                    $('.confirm-cancel').click(function() {
                        let id = $(this).attr('data-id');
                        $('#cancelModal').modal('hide');
                        window.location.replace("../controller/request_admin_reject.php?id="+id);
                    });
                    
                })

                $('.popup-message').animate({opacity: 1}, 800)
                setTimeout(function(){
                    $('.popup-message').animate({opacity: 0}, 800, function() {
                        $(this).remove();
                    });
                },3000);
            </script>
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>