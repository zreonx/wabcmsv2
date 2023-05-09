<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $allOrg = $organization->getOrganizations();
?>
    <div class="page">
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Oranization has been updated.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Oranization has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Organization Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                <div class="col-lg-5 pt-2 px-4">
                    <label class="form-label">Manage Organizations</label>
                    <div class="p-1 px-3">
                        <div class="input-cont rounded mb-3">
                            <input type="text" id="organization_code" class="input-box" required>
                            <label class="input-label">Organization Acronym</label>
                        </div>
                        <div class="input-cont">
                            <input type="text" id="organization_name" class="input-box" required>
                            <label class="input-label">Organization Name</label>
                        </div>
                        <div class="btn btn-success rounded mt-3" id="addOrgBtn">Add Organization</div>
                    </div>
                </div>
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Organizations</label>
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>Acronym</th>
                                    <th>Organization</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php $count = 1; while($org_row = $allOrg->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    
                                    <th><?php echo $org_row['organization_code']; ?></th>
                                    <td class="long-word"><?php echo $org_row['organization_name']; ?></td>
                                    <td>
                                        <button data-id="<?php echo $org_row['id']?>" class="btn btn-sm btn-success rounded small-btn edit-btn "><i class="fas fa-edit"></i> Edit</button>
                                        <button data-id="<?php echo $org_row['id']?>" class="btn btn-delete btn-sm btn-success rounded small-btn " data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php $count++; endwhile; ?>
                        </table>
                    
                        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Delete Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this organization?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button data-id="" type="button" class="btn btn-danger confirm-delete">Continue</button>
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

                    $('.edit-btn').click(function(){
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