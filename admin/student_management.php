<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $allStudents = $student->getStudents();
?>
    <div class="page">
    <?php 
        if (isset($_GET['import']) && $_GET['import'] == "success") { echo '<div class="alert alert-success" id="err">Students has been updated.</div>'; }
        if (isset($_GET['error']) && $_GET['error'] == "true") { echo '<div class="alert alert-danger" id="err">There was an error importing students.</div>'; } 
        if (isset($_GET['import']) && $_GET['import'] == "empty") { echo '<div class="alert alert-danger" id="err">Please select a CSV file.</div>'; }
        if (isset($_GET['import']) && $_GET['import'] == "invalid") {echo '<div class="alert alert-danger" id="err">Please select an appropriate file format</div>';}
        if (isset($_GET['column']) && $_GET['column'] == "false") { echo '<div class="alert alert-danger" id="err">The column of the file does not match our database.</div>'; }
    ?>
        <div class="page-header d-flex flex-wrap align-items-center gap-2 justify-content-md-between">
            <h1 class="page-title fs-5 display-6">Student Management</h1>
            <div class="d-flex gap-2 flex-wrap align-items-center justify-content-center">
                <div class="btn btn-success rounded mb-3" id="addOrgBtn" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fas me-1 fa-plus"></i> Import CSV</div>
            </div>
        </div>
        <div class="page-content p-2 rounded ">
            <div class="row"> 
                <div class="mt-2 d-flex justify-content-between">
                    <label class="form-label">Student Record</label>
                    <div class="export-btn"></div>
                </div>
                <div class="col-lg-12 px-4 my-3">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="f-d">Type</span>
                        <button type="button" class="btn btn-search btn-success btn-sm btn-rounded" id="filter-all">All</button>
                        <button type="button" class="btn btn-search btn-success btn-sm btn-rounded" id="filter-college">College</button>
                        <button type="button" class="btn btn-search btn-success btn-sm btn-rounded" id="filter-shs">SHS</button>
                        <div class="d-flex gap-2 ms-auto">
                            <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                            <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                        </div>
                    </div>
                </div>
              
                <div class="col-lg-12 px-4 mb-2">
                    <div class="custom-table px-3 pb-2">

                        <table class="table text-center display w-100 mb-2" id="my-datable">
                            
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Course / Strand</th>
                                    <th>Education Level</th>
                                    <th>Academic Level</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            
                            <?php $count = 1; while($stud_row = $allStudents->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $stud_row['student_id']; ?></td>
                                    <td><?php echo $stud_row['last_name'] . ", " . $stud_row['first_name'] . " " . $stud_row['middle_name'] //strtoupper(substr($stud_row['middle_name'], 0, 1)) ."." ?></td>
                                    <td><?php echo $stud_row['email']; ?></td>
                                    <td><?php echo $stud_row['contact_number']; ?></td>
                                    <td><?php echo $stud_row['program_course']; ?></td>
                                    <td><?php echo $stud_row['academic_level']; ?></td>
                                    <td><?php echo $stud_row['year_level']; ?></td>
                                    <td class="text-center align-middle"><?php echo ($stud_row['status'] == "imported") ? '<div class="badge-green"><i class="fas fa-circle i-dot i-success "></i> <span>Enrolled</span></div>' : ''; ?></td>
                                    <!-- <td><button data-id="<?php echo $sig_row['id']?>" class="btn btn-delete btn-sm btn-success rounded btnsm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button></td> -->
                                </tr>
                                
                            <?php $count++; endwhile; ?>
                            
                        </table>

                        <div class="modal fade custom-modal" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header x-border py-1 pt-3">
                                        <h1 class="px-1 display-6 fs-6">Import Student</h1>
                                    </div>
                                    <div class="modal-body x-border py-0">
                                        <form class="px-3 pb-3" action="../controller/student_import.php" method="post" enctype="multipart/form-data">
                                            <div class="file-upload">
                                                <label>
                                                    <input type="file" class="form-control" name="csvfile" accept=".csv">
                                                    <span>Choose CSV file or drag it here</span>
                                                </label>
                                            </div>   
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="submit" class="btn btn-success rounded" name="submit">Import</button>
                                                <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <script src="../js/filter_student.js"></script>
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