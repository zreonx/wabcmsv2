<?php 
    require_once '../includes/main_header.php'; 
    $allUser = $user->getAllUser();
?>
    <div class="page position-relative">
        <?php if(isset($_GET['deactivation'])){ echo '<div class="popup-message"><div class="alert alert-success shadow-xl" role="alert"><i class="fad me-2 fa-check-circle"></i>Account has been successfully deactivated.</div></div>'; } ?>
        <?php if(isset($_GET['activation'])){ echo '<div class="popup-message"><div class="alert alert-success shadow-xl" role="alert"><i class="fad me-2 fa-check-circle"></i>Account has been successfully activated.</div></div>'; } ?>
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Accounts Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                <div class="col-lg-12 pt-2 px-4">
                    <label class="form-label">User Account Information</label>

                   <div class="page-filter d-flex flex-wrap justify-content-sm-between gap-2 align-items-center">
                        <div class="d-flex gap-2 justify-content-sm-center mb-2 align-items-center">
                            <span class="f-d">Filter</span>
                            <button class="btn btn-search btn-success btn-sm btn-rounded" id="filterAllUser">All</button>
                            <button class="btn btn-search btn-success btn-sm btn-rounded" id="filterAllStudent">Student</button>
                            <button class="btn btn-search btn-success btn-sm btn-rounded" id="filterAllSignatory">Signatory</button>
                        </div>
                        <div class="d-flex align-self-start gap-2 mb-2">
                            <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                            <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                        </div>
                   </div>

                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <!-- <th>Password</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($allUser as $user_data): ?>
                                    <tr>
                                        <td><?php echo $user_data['user_id']; ?></td>
                                        <td><?php echo ucfirst($user_data['user_type']); ?></td>
                                        <td><?php echo $user_data['email']; ?></td>
                                        <!-- <td><?php //$user_data['password']; ?></td> -->
                                        <td class="text-center align-middle"><?php echo ($user_data['status'] == "active") ? '<div class="d-flex justify-content-center"><div class="badge-secondary"><i class="fas fa-circle i-dot i-success "></i> <span>Active</span></div></div>' : '<div class="d-flex justify-content-center"><div class="badge-danger"><i class="fas fa-circle i-dot i-danger "></i> <span>Deactivated</span></div></div>'; ; ?></td>
                                        <td>
                                            <?php if($user_data['status'] == "active"): ?>
                                                <button data-id="<?php echo $user_data['id'] ?>" data-bs-toggle="modal" data-bs-target="#deactivateModal" class="btn btn-sm btn-danger rounded btnsm deact-btn"><i class="fas fa-user-alt-slash"></i> <span class="btn-text">Deactivate</span></button>
                                            <?php elseif($user_data['status'] == "deactivated"): ?>
                                                <button data-id="<?php echo $user_data['id'] ?>" data-bs-toggle="modal" data-bs-target="#activateModal" class="btn btn-sm btn-success rounded btnsm activate-btn"><i class="fas fa-user-alt-slash"></i> <span class="btn-text">Activate</span></button>
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    
                        <div class="modal fade custom-modal " id="deactivateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Deactivate Account</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to deactivate this user?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="confirmDeactBtn" class="btn btn-danger rounded confirm-deact">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade custom-modal " id="activateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Activate Account</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center px-3">
                                            <div class="fs-1 text-success p-2">
                                                <i class="fad fa-check-circle"></i>
                                            </div>
                                            <div class="p-2 f-d">Are you sure you want to deactivate this user?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="confirmActBtn" class="btn btn-success rounded confirm-act">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/filter_student.js?v.2"></script>
            <script>
                $(document).ready(function(){

                    $('.popup-message').animate({opacity: 1}, 800)
                    setTimeout(function(){
                        $('.popup-message').animate({opacity: 0}, 800, function() {
                            $(this).remove();
                        });
                    },3000);

                    var editId;

                    setTimeout(function(){
                        $('#err').remove();
                    },3000)
                    
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

                    $(document).on('click', '#my-datable tbody .deact-btn', function() {
                        let deactId = $(this).attr('data-id');
                        $('#confirmDeactBtn').attr('data-id', deactId);  
                        console.log(deactId)
                    })

                    $(document).on('click', '#my-datable tbody .activate-btn', function() {
                        let actID = $(this).attr('data-id');
                        $('#confirmActBtn').attr('data-id', actID);  
                        console.log(actID)
                    })

                    $('#confirmActBtn').on('click', function(){
                        let actID = $('#confirmActBtn').attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "../controller/user_activate.php",
                            data: {
                                id : actID,
                            },
                            success: function(result) {
                                window.location.replace('users_management.php?activation=success');
                            }
                        })
                        console.log(deactId);
                    });

                    $('#confirmDeactBtn').on('click', function(){
                        let deactId = $('#confirmDeactBtn').attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "../controller/user_deactivate.php",
                            data: {
                                id : deactId,
                            },
                            success: function(result) {
                                window.location.replace('users_management.php?deactivation=success');
                            }
                        })
                        console.log(deactId);
                    });

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

                    function addOrganization() {
                        let orgCode = $('#organization_code').val()
                        let orgName = $('#organization_name').val()

                        if(orgCode.length !== 0 || orgName.length !== 0) {
                            $.ajax({
                                method : "POST",
                                url: "../controller/org_add.php",
                                data: {
                                    key: "add_organization",
                                    organization_code: orgCode,
                                    organization_name: orgName,
                                },
                                success: function(result) {
                                    $('#err').remove();
                                    $('.page-content').before(result);

                                    $('#organization_code').val("");    
                                    $('#organization_name').val("");

                                    setTimeout(function(){
                                        $('#err').remove();
                                    },3000)
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

                    $('.btn-delete').click(function() {
                        let id = $(this).attr('data-id');
                        $('.confirm-delete').attr('data-id',id);
                    });

                    $('.confirm-delete').click(function() {
                        let id = $(this).attr('data-id');
                        $('#deleteModal').modal('hide');
                        window.location.replace("../controller/org_delete.php?id="+id);
                    });
                    
                })
            </script>
<?php require_once '../includes/main_footer.php' ?>