<?php 
    require_once '../includes/main_header.php'; 
    $signatories = $signatory->getSignatories();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Signatory has been added.</div>'; } ?>
        <?php if(isset($_GET['update'])){ echo '<div class="alert alert-success" id="err">Signatory has been update.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Signatory has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Signatory Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/sign_add.php" method="POST">
                        <label class="form-label">Manage Signatory</label>
                        <div class="p-1 px-3">
                            <div class="input-cont mb-3">
                                <input type="text" id="firstname" name="firstname" class="input-box" placeholder="" required >
                                <label class="input-label">Firstname</label>
                            </div>
                            <div class="input-cont mb-3">
                                <input type="text" id="middlename" name="middlename" class="input-box" required>
                                <label class="input-label">Middlename</label>
                            </div>
                            <div class="input-cont mb-3">
                                <input type="text" id="lastname" name="lastname" class="input-box" placeholder="" required>
                                <label class="input-label">Lastname</label>
                            </div>
                            <div class="input-cont mb">
                                <input type="text" id="email" name="email" class="input-box" placeholder="" required>
                                <label class="input-label">Email</label>
                            </div>

                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="addSignatory">Add Signatory</button>
                        </div>

                        <script>
                           window.onload = function(){
                            $('#addSignatory').on('click',function(){
                                let middlenameInput = $('#middlename').val();
                                if(middlenameInput ==  ''){
                                    $("#middlename").removeAttr('required');
                                }
                            })
                           }
                        </script>
                    </form>
                </div>

               

               
                <div class="col-lg-7 pt-2 px-4">
                       <div class="d-flex flex-wrap justify-content-between">
                            <label class="form-label">List of Signatories</label>
                            <div class="d-flex gap-2 mb-2">
                                <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                                <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                            </div>
                       </div>
                    <div class="custom-table px-3 pb-3">
                        <table class="table text-center display w-100 mb-2" id="my-datable"">
                            <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Workplace</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($sig_row = $signatories->fetch(PDO::FETCH_ASSOC)):  ?>
                                <tr>
                                    <th>
                                        <?php
                                            $midname = ($sig_row['middle_name'] == '') ? '' : strtoupper(substr($sig_row['middle_name'], 0, 1) . '.');
                                            echo $sig_row['last_name'] . ", " . $sig_row['first_name'] . " " . $midname;
                                        ?>
                                    </th>
                                    <td class="long-word"> 
                                        <?php 
                                            $category_workplace = $signatory->getSignatoryDesignations($sig_row['id']);

                                            $wp_value = array();
                                            foreach($category_workplace as $cw){
                                                $val =  $designation->getWorkplace($cw['category'], $cw['signatory_workplace']);
                                                array_push($wp_value, $val);
                                            }
                                            if(!empty($wp_value)){
                                                echo implode(', ', $wp_value);
                                            }else {
                                                echo "Unassigned";
                                            }       
                                        ?>
                                    </td>
                                    <td>
                                        <button data-id="<?php echo $sig_row['id'] ?>" class="btn btn-sm btn-primary rounded edit-btn"> <i class="fas fa-edit"></i> Edit</button>
                                        <button data-id="<?php echo $sig_row['id']?>" class="btn btn-delete btn-sm btn-danger rounded " data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                          
                        </table>

                        <div class="modal fade custom-modal " id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Delete Organization</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2 align-items-center">
                                           
                                            <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-1">
                                                <span class="fs-1 text-danger p-4">
                                                        <i class="fas fa-trash fs-1"></i>
                                                </span>    
                                                <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to delete this signatory?</div> 
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="removeSignatory" class="btn btn-danger rounded confirm-delete">Confirm</button>
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
                
                setTimeout(function(){
                    $('#err').remove();
                },3000);

                var id;

                $('#my-datable tbody').on('click', '.edit-btn',function(){
                    $('#email').prop("readonly", true);
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

                
                $('.btn-delete').click(function() {
                    let id = $(this).attr('data-id');
                    $('.confirm-delete').attr('data-id',id);
                });

                $('.confirm-delete').click(function() {
                    let id = $(this).attr('data-id');
                    $('#deleteModal').modal('hide');
                    window.location.replace("../controller/sign_delete.php?id="+id);
                });

                var timeoutId;

                $('#email').keyup(function(){
                    clearTimeout(timeoutId); 
                    
                    timeoutId = setTimeout(function() {
                        var email = $('#email').val();
                        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
                        if (!emailRegex.test(email)) {
                            $('.text-danger.f-s').remove();
                            $('#email').after('<div class="px-2 mt-1"><span class="text-danger f-s">Email is not valid</span></div>');
                        } else {
                            $('.text-danger.f-s').remove();
                        }
                    }, 500);
                });

            </script>
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>