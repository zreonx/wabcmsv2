<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    
    $designations = $designation->getAllDesignationData();


    //Select Options

    $categories = $designation->getCategory();

    $organizations = $organization->getOrganizations();
    $departments = $department->getDepartments();
    $offices = $office->getOffices();
    $shschools = $shs->getStrands();


    $dept_json = json_encode($departments->fetchAll(PDO::FETCH_ASSOC));
    $office_json = json_encode($offices->fetchAll(PDO::FETCH_ASSOC));
    $org_json = json_encode($organizations->fetchAll(PDO::FETCH_ASSOC));
    $shs_json = json_encode($shschools->fetchAll(PDO::FETCH_ASSOC));

    $signatories = $signatory->getSignatories();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Designation has been added.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Department has been deleted.</div>'; } ?>
        <?php if(isset($_GET['assign'])){ echo '<div class="alert alert-success" id="err">Designation has been assigned.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Designation Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../controller/add_designation_info.php" method="POST">
                        <label class="form-label">Manage Designation</label>
                        <div class="p-1 px-3">
                           <div class="mb-2">
                                <div class="custom-select select-category">
                                    <input type="hidden" class="select-name" name="category" id="category">
                                    <button type="button" class="select-btn categoryBtn"> 
                                        <span class="sbtn-text" id="categoryText">Select Signatory Category</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Select Category</li>
                                        <?php while($row_cat = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                                            <li data-value="<?php echo $row_cat['id']; ?>"><?php echo $row_cat['category']; ?></li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                           </div>
                           <div class="mb-2">
                                <div class="custom-select select-workplace">
                                    <input type="hidden" class="select-name" name="workplace" id="workplace">
                                    <button type="button" class="select-btn categoryBtn"> 
                                        <span class="sbtn-text" id="workplaceText">Select Workplace</span>
                                        <i class="bx bx-chevron-down"></i>
                                    </button>
                                    <ul class="select-menu">
                                        <li data-value="0">Select Workplace</li>
                                    </ul>
                                </div>
                           </div>
                           
                            <div class="input-cont">
                                <input type="text" id="designation_name" name="designation_name" class="input-box" required>
                                <label class="input-label">Designation Name</label>
                            </div>
                            <button id="preAddBtn" type="button" class="btn btn-success rounded mt-3" data-bs-toggle="modal" data-bs-target="#confirmAddDesignation">Add Designation</button>
                        </div>


                        <div class="modal fade custom-modal" id="confirmAddDesignation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Designation Information</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        
                                        <div>
                                            
                                            <div class="default-border py-2 px-3">
                                                
                                                
                                                <table class="table table-borderless w-auto mt-1">
                                                    <tr>
                                                        <td><span>Category:</span></td>
                                                        <td><strong><i id="category-text">Testing</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Workplace:</span></td>
                                                        <td><strong><i id="workplace-text">Testing</i></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Designation:</span></td>
                                                        <td><strong><i id="designation-text">Testing</i></strong></td>
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
                                            <button type="submit" name="submit" class="btn btn-success rounded" id="addDesignation">Add Designation</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="mt-3 activate-designations">
                        <label class="form-label">Setup Signatory Designations</label>
                        <div class="">
                            <button type="button" class="btn btn-success rounded" id="activateDesignations">Setup All Designations</button>
                            <button type="button" class="btn btn-success rounded" id="deleteDesignations">Delete all table dev</button>
                        </div>
                    </div>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Signatory Designations</label>
                    <div class="d-flex justify-content-end mb-2 ">
                        <div class="form-group d-flex gap-2">
                            <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                            <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button>
                        </div>
                    </div>  
                    <div class="custom-table">
                        <table class="table text-center display w-100 mb-2" id="my-datable">
                            <thead>
                                <tr>
                                    <th>Signatory</th>
                                    <th>Workplace</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($d_row = $designations->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <span class="d-flex justify-content-center align-items-center">
                                            <?php 
                                                $s_info = $designation->getSignatoryInformation($d_row['id']);
                                                if(!empty($s_info)) {
                                                    echo $s_info['last_name'] . ", " . $s_info['first_name'] . " " . strtoupper(substr($s_info['middle_name'], 0, 1)) ."." ;
                                                    ?>
                                                </span>
                                                <button data-id="<?php echo $d_row['id'] ?>" class="btn btn-sm small-btn btn-remove btn-danger" data-bs-toggle="modal" data-bs-target="#removeAssignment"><i class="fas fa-user-times"></i></button>
                                                <?php }else {
                                                    echo '<span class="badge bg-secondary me-2">Unassigned</span>';
                                                ?>
                                                <button data-id="<?php echo $d_row['id'] ?>" class="btn btn-sm small-btn btn-add btn-success" data-bs-toggle="modal" data-bs-target="#assignModal"><i class="fas fa-user-plus"></i></button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                         <div class="p-1">
                                            <?php
                                                echo $cats = $designation->getWorkplace($d_row['category'], $d_row['signatory_workplace']); 
                                            ?>
                                        </div>
                                    </td>
                                    <td><div class="p-1"><?php echo $d_row['designation'] ?></td></div>
                                    <td>
                                        <!-- <button data-id="<?php //echo $d_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn">Edit</button> -->
                                        <button data-id="<?php echo $d_row['id']?>" class="btn btn-delete btn-sm small-btn btn-success rounded" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </table>


                        <div class="modal fade custom-modal " id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Delete Designation</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-trash"></i>
                                            </div>
                                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to delete this designation?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="removeSignatory" class="btn btn-danger rounded confirm-remove">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade custom-modal " id="removeAssignment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content ">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Unassign Signatory</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                                            <div class="fs-1 text-danger p-2">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="p-2 f-d">Are you sure you want to unassign this signatory?</div>
                                        </div>
                                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                            <button id="removeSignatory" class="btn btn-danger rounded confirm-remove">Confirm</button>
                                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="modal fade custom-modal" id="assignModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-5">Assign Signatory</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        
                                        <div class="search-signatory d-flex gap-1 mb-2 w-50">
                                            <input class="form-control form-control-sm" type="text" id="searchSignatory" placeholder="Search...">
                                            <button class="btn btn-search btn-success btn-sm rounded">SEARCH</button>
                                        </div>
                                        <div id="search-list">
                                            
                                        </div>
                                        <div class="d-flex justify-content-between my-2 mb-3 gap-2">
                                            <a href="signatory_management.php" class="btn btn-outline-success rounded">Create New Signatory</a>
                                            <button type="button" class="btn btn-outline-secondary rounded" data-bs-dismiss="modal">Cancel</button>
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

                    var department = <?php echo $dept_json ; ?>;
                    var organization = <?php echo $org_json ; ?>;
                    var office = <?php echo $office_json ; ?>;
                    var shs = <?php echo $shs_json ; ?>;

                    const selectCategoryOptions = document.querySelectorAll('.select-category .select-menu li');
                    $('.categoryBtn').click(function(){
                        selectCategoryOptions.forEach(function(option){
                            option.addEventListener('click', function(){
                                let selectedValue = option.dataset.value;
                                $('.select-workplace .select-btn .sbtn-text').text("Select Workplace")
                                switch(selectedValue) {
                                    case "1":
                                        //Program Head
                                        $('.input-cont').hide();
                                        $('#designation_name').prop('disabled', true);

                                        $('.select-workplace .select-menu').html('');
                                        $(".select-workplace .select-menu").append("<li data-value='0'>Select Workplace</li>");
                                        for(let i = 0; i < department.length; i++) {
                                            var newOption = $("<li></li>");
                                            newOption.attr('data-value', department[i].id);
                                            newOption.text(department[i].department_code + " - " + department[i].department_name);
                                            $(".select-workplace .select-menu").append(newOption);
                                        }
                                        initializeCustomSelect();
                                    break;
                                    case "2":
                                        //Offices
                                        $('.input-cont').show();
                                        $('#designation_name').prop('disabled', false);

                                        $('.select-workplace .select-menu').html('');
                                        $(".select-workplace .select-menu").append("<li data-value='0'>Select Workplace</li>");
                                        for(let i = 0; i < office.length; i++) {
                                            var newOption = $("<li></li>");
                                            newOption.attr('data-value', office[i].id);
                                            newOption.text(office[i].office_name);
                                            $(".select-workplace .select-menu").append(newOption);
                                        }
                                        initializeCustomSelect();
                                        
                                    break;
                                    case "3":
                                        //SHS
                                        $('.input-cont').show();
                                        $('#designation_name').prop('disabled', false);

                                        $('.select-workplace .select-menu').html('');
                                        $(".select-workplace .select-menu").append("<li data-value='0'>Select Workplace</li>");
                                        for(let i = 0; i < shs.length; i++) {
                                            var newOption = $("<li></li>");
                                            newOption.attr('data-value', shs[i].id);
                                            newOption.text(shs[i].strand);
                                            $(".select-workplace .select-menu").append(newOption);
                                        }
                                        initializeCustomSelect();
                                    break;
                                    case "4":
                                        //Organization
                                        $('.input-cont').show();
                                        $('#designation_name').prop('disabled', false);

                                        $('.select-workplace .select-menu').html('');
                                        $(".select-workplace .select-menu").append("<li data-value='0'>Select Workplace</li>");
                                        for(let i = 0; i < organization.length; i++) {
                                            var newOption = $("<li></li>");
                                            newOption.attr('data-value', organization[i].id);
                                            newOption.text(organization[i].organization_code + " - " + organization[i].organization_name);
                                            $(".select-workplace .select-menu").append(newOption);
                                        }
                                        initializeCustomSelect();
                                    break;
                                    default:
                                        $('.select-workplace .select-menu').html('');
                                        $(".select-workplace .select-menu").append("<li data-value='0'>Select Workplace</li>");
                                    break;
                                }
                            }); 
                        });
                    });


                    let searchTimeout;
                    var assignedSignatoryId;
                    var designationId;

                    $('#preAddBtn').click(function(){
                        let categoryText = $('#categoryText').text();
                        let workplaceText = $('#workplaceText').text();
                        let designationText = $('input[name="designation_name"]').val();

                      
                       

                       if(categoryText === "Program Head") {
                            $('#category-text').text("Department");
                            $('#workplace-text').text(workplaceText);
                            $('#designation-text').text("Program Head");
                       }else {
                            $('#category-text').text(categoryText);
                            $('#workplace-text').text(workplaceText);
                            $('#designation-text').text(designationText);
                       }
                     
                    })

                    $('.btn-add').click(function(){
                        $('#search-list').html('');
                        $('#searchSignatory').val("");
                        designationId = $(this).attr('data-id')
                    });

                    $('.btn-remove').click(function(){
                        designationId = $(this).attr('data-id')
                        $('.confirm-remove').attr('data-id', designationId);
                    });

                    $('#removeSignatory').click(function(){
                       let removeId = $(this).attr('data-id');
                        window.location.replace("../controller/designation_remove.php?designation_id=" + removeId);
                    })

                    $('#searchSignatory').on('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(function() {
                            let searchValue = $('#searchSignatory').val();
                            $.ajax({
                                type: "POST",
                                url: "../controller/designation_search.php",
                                data: {
                                    search_data: searchValue,
                                },
                                success: function(response) {
                                    $('#search-list').html(loadinAnimation());
                                    setTimeout(function() {
                                        if(searchValue.length !== 0) {
                                            $('#search-list').html(response);
                                        }else {
                                            $('#search-list').html('<h1 class="display-6 fs-6 text-center text-success">    Signatory does not exist.</h1>');
                                        }
                                    },3000)
                                }
                            }) 
                        }, 1000);
                    });


                   
                    $(document).on('click', '.assign-btn', function(){
                        assignedSignatoryId = $('.assign-btn').attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "../controller/designation_assign.php",
                            data: {
                                designation_id: designationId,
                                assigned_signatory: assignedSignatoryId,
                            },
                            success: function(response){
                                window.location.replace('add_designation_information.php?assign=success');
                            }
                        });
                    });

                    $('#activateDesignations').click(function() {
                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_designation_table.php",
                            data: {
                                key : "activate",
                            },
                            success: function(result) {
                                let response = JSON.parse(result);
                                $('.page-content').before(response.message);
                                //console.log(result);
                                setTimeout(function(){
                                    $('#err').remove();
                                },3000);

                            }
                        })
                    });

                    $('#deleteDesignations').click(function() {
                        $.ajax({
                            method : "POST",
                            url: "../controller/clearance_delete_table.php",
                            data: {
                                key : "delete",
                            },
                            success: function(result) {
                                let response = JSON.parse(result);
                                $('.page-content').before(response.message);
                                setTimeout(function(){
                                    $('#err').remove();
                                },3000);
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