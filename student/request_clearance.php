<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $allOrg = $organization->getOrganizations();
?>
    <div class="page">
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Request Clearance</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                <div class="col-lg-5 pt-2 px-4">
                    <label class="form-label">Request Information</label>
                    <div class="p-1 px-3">
                        <div class="mb-3">
                            <div class="custom-select select-clearance-type">
                                <input type="hidden" class="select-name" name="clearance_type" id="clearance_type">
                                <button type="button" class="select-btn"> 
                                    <span class="sbtn-text" id="cttext">Clearance Type</span>
                                    <i class="bx bx-chevron-down"></i>
                                </button>
                                <ul class="select-menu">
                                    <li data-value="0">Clearance Type</li>
                                   
                                            <li data-value="0">Test</li>
                                </ul>
                            </div>
                           </div>
                        <div class="input-cont">
                            <textarea class="input-box" required name="reason" id="" cols="30" rows="10"></textarea>
                            <label class="input-label">Reason for request</label>
                        </div>
                        <div class="btn btn-success rounded mt-3" id="addOrgBtn">Add Organization</div>
                    </div>
                </div>
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Request List</label>
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>Requested Clearance</th>
                                    <th>Date Requested</th>
                                    <th>Satus</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                                <tr>
                                    
                                    <td></td>
                                    <td class="long-word"></td>
                                    <td></td>
                                    <td>
                                        <button data-id="" class="btn btn-sm btn-success rounded small-btn edit-btn "><i class="fas fa-edit"></i> Edit</button>
                                        <button data-id="" class="btn btn-delete btn-sm btn-success rounded small-btn " data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                        </table>
                    
                        <div class="modal fade custom-modal " id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Delete Organization</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to delete this organization?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="removeSignatory" class="btn btn-danger rounded confirm-remove">Confirm</button>
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
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>