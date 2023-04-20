<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';

    $clearanceTypes = $clearance->getClearanceType();
    $clearances = $clearance->getAllClearance();
    $beneficiaries = $clearance->getBeneficiaries();
?>
    <div class="page">
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
                                        <span class="sbtn-text">Clearance Recipient</span>
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
                                        <span class="sbtn-text">Clearance Type</span>
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
                                        <span class="sbtn-text">Academic Year</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Academic Year</li>
                                        <li data-value="2022-2023">2022-2023</li>
                                        <li data-value="2023-2024">2023-2024</li>
                                    </ul>
                                </div>
                           </div>

                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="clearanceBtn">Create Clearance</button>
                        </div>
                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Clearance Records</label>
                    <div class="custom-table default-height-overflow">
                        <table class="table table-hover">
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
                                        <td><?php echo $c_row['clearance_name'] ?></td>
                                        <td><?php echo $c_row['beneficiary'] ?></td>
                                        <td><?php echo $c_row['semester'] ?></td>
                                        <td><?php echo $c_row['academic_year'] ?></td>
                                        <td>
                                            
                                            <button data-id="<?php echo $c_row['clearance_id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                            <button data-id="<?php echo $c_row['clearance_id'] ?>" class="btn btn-sm btn-success rounded btnsm status-btn" data-bs-toggle="modal" data-bs-target="#clearanceDashboard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clearance Status" data-bs-custom-class="custom-tooltip"><i class="fas fs-6 fa-sliders-h"></i></button>
                                        </td>
                                    </tr>

                                <?php $count++; endwhile; ?>
                        
                        </table>


                        <div class="modal fade custom-modal" id="clearanceDashboard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Clearance Status</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                    
                                        <div id="search-list">
                                            <table class="table">
                                                <th>ID</th>
                                                <th>Recipient</th>
                                                <th>Semester</th>
                                                <th>Academic Year</th>
                                                <th>Status</th>
                                            </table>
                                        </div>
                                        
                                        <div class="d-flex my-2 mb-3 gap-2">
                                            <button id="deploySignatoryBtn" class="btn btn-success rounded">Deploy to Signatories</button>
                                            <button href="signatory_management.php" class="btn btn-success rounded" disabled>Deploy to Students</button>
                                            <button type="button" class="btn btn-secondary rounded ms-auto" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade custom-modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Delete Clearance</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="ps-1 pb-3">Are you sure you want to delete this clearance?</div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="deleteClearance" class="btn btn-danger rounded confirm-delete">Confirm</button>
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

                    var id;

                    $('.edit-btn').on('click', function(){
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
                        let idDelete = $(this).attr('data-id');
                        $('.confirm-delete').attr('data-id', idDelete);
                    });

                    $('.confirm-delete').click(function() {
                        let idDelete = $(this).attr('data-id');
                        $('#deleteModal').modal('hide');
                        window.location.replace("../controller/clearance_delete.php?id=" + idDelete);
                    });

                    $('.status-btn').click(function() {
                        let clearance_id = $(this).attr('data-id');
                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_get_info.php",
                            data: {
                                id : clearance_id,
                            },
                            success: function(result) {
                                let resultData = JSON.parse(result);
                                let beneficiary = resultData.clearance_beneficiary;
                                $.ajax({
                                    method : "POST",
                                    url: "../controller/clearance_designation_table.php",
                                    data: {
                                        id : clearance_id,
                                        clearance_beneficiary: resultData.clearance_beneficiary,
                                        clearance_type: resultData.clearance_type,
                                        semester: resultData.semester,
                                        academic_year: resultData.academic_year,
                                    },
                                    success: function(response) {
                                        console.log(response)
                                    }
                                });

                               console.log(result);
                            }
                        })
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