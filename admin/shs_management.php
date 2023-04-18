<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $allStrands = $shs->getStrands();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Strand has been added.</div>'; } ?>
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Strand information has been update.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Strand has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">SHS Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/shs_add.php" method="POST">
                        <label class="form-label">Manage SHS Strand</label>
                        <div class="p-1 px-3">
                            <div class="input-cont mb-3">
                                <input type="text" id="strand" name="strand" class="input-box" required>
                                <label class="input-label">Strand</label>
                            </div>
                            <div class="input-cont">
                                <input type="text" id="description" name="description" class="input-box" required>
                                <label class="input-label">Academic Track</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="addStrandBtn">Add Strand</button>
                        </div>
                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">SHS Strand</label>
                    <div class="custom-table default-height-overflow">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Strand</th>
                                    <th>Academic Track</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($shs_row = $allStrands->fetch(PDO::FETCH_ASSOC)):  ?>
                                <tr>
                                    <th><?php echo $shs_row['strand'] ?></th>
                                    <td><?php echo $shs_row['description'] ?></td>
                                    <td>
                                        <button data-id="<?php echo $shs_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn">Edit</button>
                                        <button data-id="<?php echo $shs_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
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
                        url: "../controller/shs_edit.php",
                        data: {
                            id : id,
                        },
                        success: function(result) {
                            $('#addStrandBtn').text("Save Changes");
                            let shs_info = JSON.parse(result);
                            $('#strand').val(shs_info.strand)
                            $('#description').val(shs_info.description)
                            $('#addStrandBtn').attr('type', 'button')
                        }
                    })
                })

                $('#addStrandBtn').click(function(){
                    if($(this).attr('type') === 'button') {
                        saveChanges();
                    }
                })

                function saveChanges() {
                    let strand = $('#strand').val()
                    let description = $('#description').val()
                    
                    if(strand.length !== 0 || description.length !== 0) {
                        $.ajax({
                            method : "POST",
                            url: "../controller/shs_update.php",
                            data: {
                                id : id,
                                strand: strand,
                                description: description,
                            },
                            success: function(result) {
                                window.location.replace('shs_management.php?update=success');
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