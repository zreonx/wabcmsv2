<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    
    $designations = $designation->getAllDesignationData();


    //Select Options

    $categories = $designation->getCategory();
    $organizations = $organization->getOrganizations();
    $departments = $department->getDepartments();


    $dept_json = json_encode($departments->fetchAll(PDO::FETCH_ASSOC));
    $org_json = json_encode($organizations->fetchAll(PDO::FETCH_ASSOC));
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Department has been added.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Department has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Designation Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                

                <div class="col-lg-5 pt-2 px-4">
                    <form action="../add_designations_info.php" method="POST">
                        <label class="form-label">Manage Designation</label>
                        <div class="p-1 px-3">
                           <div class="mb-2">
                                <select class="f-d form-select" name="category" id="category">
                                    <option value="0">Select Category</option>
                                    <?php while($row_cat = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo $row_cat['id']; ?>"> <?php echo $row_cat['category']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                           </div>
                           <div class="mb-2">
                                <select class="f-d form-select" name="workplace" id="workplace">
                                    <option value="0">Select Workplace</option>
                                </select>
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
                    <label class="form-label">List of Departments</label>
                    <div class="custom-table default-height-overflow">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Assigned Signatory</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php while($d_row = $designations->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo $d_row['signatory_id'] ?></td>
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
                $(document).ready(function() {
                
                    var department = <?php echo $dept_json ; ?>;
                    var organization = <?php echo $org_json ; ?>;

                    console.log(department);

                    $('#category').on('change', function() {
                        let categoryValue = $(this).val();

                        switch(categoryValue) {
                            case "1":
                                $('.input-cont').hide();
                                $('#workplace').html('');
                                $("#workplace").append("<option value='0'>Select Workplace</option>");
                                 for(let i = 0; i < department.length; i++) {
                                    var newOption = $("<option></option>");
                                    newOption.val(department[i].id);
                                    newOption.text(department[i].department_code);
                                    $("#workplace").append(newOption);
                                }
                            break;
                            case "2":
                                //Offices
                            break;
                            case "3":
                                //SHS
                            break;
                            case "4":
                                //Organization
                                $('.input-cont').show();
                                $('#workplace').html('');
                                $("#workplace").append("<option value='0'>Select Workplace</option>");
                                 for(let i = 0; i < organization.length; i++) {
                                    var newOption = $("<option></option>");
                                    newOption.val(organization[i].id);
                                    newOption.text(organization[i].organization_code + " - " + organization[i].organization_name);
                                    $("#workplace").append(newOption);
                                }
                            break;
                            default:
                                 $('#workplace').html('');
                                 $("#workplace").append("<option value='0'>Select Workplace</option>");
                            break;
                        }
                    });
                });
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>