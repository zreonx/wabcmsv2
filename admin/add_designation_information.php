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
                                        <span class="sbtn-text">Select Signatory Category</span>
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
                                        <span class="sbtn-text">Select Workplace</span>
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
                            <button type="submit" name="submit" class="btn btn-success rounded mt-3" id="addDesignation">Add Designation</button>
                        </div>
                    </form>
                </div>

               
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Signatory Designations</label>
                    <div class="custom-table default-height-overflow">
                        <table class="table table-hover">
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
                                            <?php echo ($d_row['signatory_id'] != "") ? '<span class="badge bg-success">Occupied</span>' : '<span class="badge bg-secondary">Unassigned</span>' ; ?>
                                            <button class="btn btn-sm btn-add btn-success" data-bs-toggle="modal" data-bs-target="#assignModal"><i class="fas fa-user-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="p-1"><?php echo $designation->getWorkplace($d_row['category']);  ?></div>
                                    </td>
                                    <td><div class="p-1"><?php echo $d_row['designation'] ?></td></div>
                                    <td>
                                        <button data-id="<?php echo $d_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn">Edit</button>
                                        <button data-id="<?php echo $d_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
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
                                        Are you sure you want to delete this designation?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button data-id="" type="button" class="btn btn-danger confirm-delete">Continue</button>
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
                    $('.btn-add').click(function(){
                        $('#search-list').html('');
                        $('#searchSignatory').val("");
                    });

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