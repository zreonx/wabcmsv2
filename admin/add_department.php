<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $departments = $department->getDepartments();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Department has been added.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Department has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Department Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/dept_add.php" method="POST">
                        <label class="form-label">Manage Department</label>
                        <div class="p-1 px-3">
                            <div class="input-cont mb-3">
                                <input type="text" id="department_code" name="department_code" class="input-box" required>
                                <label class="input-label">Department Acronym</label>
                            </div>
                            <div class="input-cont">
                                <input type="text" id="department_name" name="department_name" class="input-box" required>
                                <label class="input-label">Department Description</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="addDeptBtn">Add Department</button>
                        </div>
                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">List of Departments</label>
                    <div class="custom-table default-height-overflow">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($dept_row = $departments->fetch(PDO::FETCH_ASSOC)):  ?>
                                <tr>
                                    <th><?php echo $dept_row['department_code'] ?></th>
                                    <td><?php echo $dept_row['department_name'] ?></td>
                                    <td>
                                        <button data-id="<?php echo $dept_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn">Edit</button>
                                        <button data-id="<?php echo $dept_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
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
                                        Are you sure you want to delete this department?
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
                        url: "../controller/dept_edit.php",
                        data: {
                            id : id,
                        },
                        success: function(result) {
                            $('#addDeptBtn').text("Save Changes");
                            let dept_info = JSON.parse(result);
                            
                            $('#department_code').val(dept_info.department_code)
                            $('#department_name').val(dept_info.department_name)
                            $('#addDeptBtn').attr('type', 'button')
                        }
                    })
                })

                $('#addDeptBtn').click(function(){
                    if($(this).attr('type') === 'button') {
                        saveChanges();
                    }
                })

                function saveChanges() {
                    let deptCode = $('#department_code').val()
                    let deptName = $('#department_name').val()
                    
                    if(deptCode.length !== 0 || deptName.length !== 0) {
                        $.ajax({
                            method : "POST",
                            url: "../controller/dept_update.php",
                            data: {
                                id : id,
                                department_code: deptCode,
                                department_name: deptName,
                            },
                            success: function(result) {
                                window.location.replace('add_department.php?update=success');
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
                    window.location.replace("../controller/dept_delete.php?id="+id);
                });
                

            </script>
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>