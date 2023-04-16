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
                                    <th>Assigned Signatory</th>
                                    <th>Workplace</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($d_row = $designations->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo ($d_row['signatory_id'] == "1") ? '<span class="badge bg-success">Occupied</span>' : '<span class="badge bg-secondary">Unassinged</span>' ; ?></td>
                                    <td><?php echo $designation->getWorkplace($d_row['category']);  ?></td>
                                    <td><?php echo $d_row['designation'] ?></td>
                                    <td>
                                        <button data-id="<?php echo $d_row['id'] ?>" class="btn btn-sm btn-success rounded btnsm edit-btn">Edit</button>
                                        <button data-id="<?php echo $d_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </table>
                    

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