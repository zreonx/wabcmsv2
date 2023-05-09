<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $allOffice = $office->getOffices();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Office has been added.</div>'; } ?>
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Office has been update.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Office has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Office Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/office_add.php" method="POST">
                        <label class="form-label">Manage Offices</label>
                        <div class="p-1 px-3">
                            <div class="input-cont">
                                <input type="text" id="office_name" name="office_name" class="input-box" required>
                                <label class="input-label">Office Name</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="addOfficeBtn">Add Office</button>
                        </div>
                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">List of Offices</label>
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>Offices</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($office_row = $allOffice->fetch(PDO::FETCH_ASSOC)):  ?>
                                <tr>
                                    <th><?php echo $office_row['office_name'] ?></th>
                                    <td>
                                        <button data-id="<?php echo $office_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn"><i class="fas fa-edit"></i> Edit</button>
                                        <button data-id="<?php echo $office_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                          
                        </table>
                        <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Delete Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this office?
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
                
                setTimeout(function(){
                    $('#err').remove();
                },3000);

                var id;

                $('.edit-btn').on('click', function(){
                    id = $(this).attr('data-id')
                    $.ajax({
                        type: "GET",
                        url: "../controller/office_edit.php",
                        data: {
                            id : id,
                        },
                        success: function(result) {
                            $('#addOfficeBtn').text("Save Changes");
                            let office_info = JSON.parse(result);
                            
                            $('#office_name').val(office_info.office_name)
                            $('#addOfficeBtn').attr('type', 'button')
                        }
                    })
                })

                $('#addOfficeBtn').click(function(){
                    if($(this).attr('type') === 'button') {
                        saveChanges();
                    }
                })

                function saveChanges() {
                    let officeName = $('#office_name').val()
                    
                    if(officeName.length !== 0) {
                        $.ajax({
                            method : "POST",
                            url: "../controller/office_update.php",
                            data: {
                                id : id,
                                office_name: officeName,
                            },
                            success: function(result) {
                                window.location.replace('office_management.php?update=success');
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
                    window.location.replace("../controller/office_delete.php?id="+id);
                });
                

            </script>
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>