<?php 
    require_once '../includes/main_header.php'; 


    $clearance_id = $_GET['clearance_id'];

    $clearanceStudent = $clearance->getStudentClearance($clearance_id);
    $clearance_info = $clearance->getClearanceInfo($clearance_id);
    $clearance_info =$clearance_info->fetch(PDO::FETCH_ASSOC);

    //getStudentInfo($student_id)
?>
    <div class="page px-4">
        <?php 
            if (isset($_GET['import']) && $_GET['import'] == "success") { echo '<div class="alert alert-success" id="err">Deficiency has been added.</div>'; }
            if (isset($_GET['error']) && $_GET['error'] == "true") { echo '<div class="alert alert-danger" id="err">There was an error importing students.</div>'; } 
            if (isset($_GET['import']) && $_GET['import'] == "empty") { echo '<div class="alert alert-danger" id="err">Please select a CSV file.</div>'; }
            if (isset($_GET['import']) && $_GET['import'] == "invalid") {echo '<div class="alert alert-danger" id="err">Please select an appropriate file format</div>';}
            if (isset($_GET['column']) && $_GET['column'] == "false") { echo '<div class="alert alert-danger" id="err">The column of the file does not match our database.</div>'; }
        ?>
        <div class="d-flex flex-wrap gap-2 justify-content-lg-between align-items-center mb-2 ">
            <h1 class="fs-5 display-6 py-1 m-0"><i class="fas fa-th-list text-success me-2"></i> Student Clearance Record</h1>
            
        </div>
        <div class="page-content p-2 rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                
                <div class="modal fade custom-modal " id="clearAllConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-header x-border py-1 pt-3">
                                <h1 class="px-1 display-6 fs-5">Clear All Students</h1>
                            </div>
                            <div class="modal-body x-border py-0">
                                <div class="d-flex gap-2justify-content-center align-items-center success-notice p-3">
                                    <div class="fs-1 text-success p-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="p-2 f-d">Notice! This will clear students with and without deficiencies. Are you sure you want to continue?</div>
                                </div>
                                <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                                    <button id="clearAllConfirmModal" class="btn btn-success rounded confirm-remove">Yes</button>
                                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="default-border rounded-end mb-2 w-100 d-flex berow gap-3">
                <div class="f-d badge bg-success rounded-0 rounded-start" data-bs-toggle="tooltip" title="Clearance Reference Number">CRN <?php echo($_GET['clearance_id']); ?></div>
                <div class="d-flex justify-content-between align-items-center flex-grow-1 px-2">
                    <h1 class="f-d display-6 mb-0"><?php echo $clearance_info['clearance_name'] ?></h1>
                    <h1 class="f-d display-6 mb-0"><?php echo $clearance_info['semester'] ?></h1>
                    <h1 class="f-d display-6 mb-0">A.Y. <?php echo $clearance_info['academic_year'] ?></h1>
                </div>
                <button id="printReport" class="d-none btn btn-success rounded dis-btn fs-5" data-bs-toggle="tooltip" title="Print Student Clearance"><i class="fas fa-print"></i></button>
            </div>
            <div class="d-flex justify-content-between align-items-end mb-2 ">
                <h1 class="fs-6 display-6 mb-0">Students</h1>
                <div class="form-group d-flex gap-2">
                    <input class="form-control form-control-sm" type="text" id="search-val" placeholder="Search...">
                    <!-- <button class="btn btn-search btn-success btn-sm rounded" id="searchBtn">SEARCH</button> -->
                </div>
            </div>  
            <div>
                <div class="custom-table px-3 pb-3">
                    <table class="table display w-100 mb-2 text-center" id="my-datable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Education Level</th>
                                <th>Program | Course</th>
                                <th>Academic Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach($clearanceStudent as $stud): ?>
                                <?php 
                                    $des_student = $clearance->getStudentInfo($stud['student_id']);
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $des_student['student_id'] ?></td>
                                    <td><?php echo $des_student['last_name'] . ", " . $des_student['first_name'] . " " . $des_student['middle_name'] //strtoupper(substr($stud_row['middle_name'], 0, 1)) ."." ?></td>
                                    <td><?php echo $des_student['academic_level'] ?></td>
                                    <td><?php echo $des_student['program_course'] ?></td>
                                    <td>
                                        <?php 
                                            switch($des_student['year_level']){
                                                case '1' : 
                                                    echo $des_student['year_level'] . "st Year";
                                                break ;
                                                case '2' : 
                                                    echo $des_student['year_level'] . "nd Year";
                                                break ;
                                                case '3' : 
                                                    echo $des_student['year_level'] . "rd Year";
                                                break ;
                                                case '4' : 
                                                    echo $des_student['year_level'] . "th Year";
                                                break ;
                                                default:
                                                    echo 'Grade ' . $des_student['year_level'];
                                                break ;
                                            }
                                        ?>
                                    </td>
                                    <td style="width: 180px">
                                        <button data-id="<?php echo $des_student['student_id'] ?>" data-value="<?php echo $clearance_id; ?>" class="btn btn-view btn-sm btn-success rounded btnsm w-50 view-clearance" data-bs-toggle="modal" data-bs-target="#viewClearanceModal"><i class="fas fa-clipboard-list-check mr-2"></i> View</button>
                                    </td>
                                    
                                </tr>
                            <?php $count++; endforeach; ?>
                        </tbody>
                            
                    
                    </table>

                    <div class="modal fade" id="viewClearanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Student Clearance</h1>
                                </div>
                                <div id="studentClearanceData" class="h-100">

                                </div>
                                <div class="p-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="modal fade custom-modal" id="importOther" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header x-border py-1 pt-3">
                                    <h1 class="px-1 display-6 fs-6">Import Deficient Student</h1>
                                </div>
                                <div class="modal-body x-border py-0">
                                    <form class="px-3 pb-3" action="../controller/signatory_import_other.php" method="post" enctype="multipart/form-data">
                                    
                                    <div class="file-upload">
                                        <label>
                                            <input type="file" class="form-control" name="csvfile" accept=".csv">
                                            <span>Choose CSV file or drag it here</span>
                                        </label>
                                    </div>   
                                    
                                    <div class="py-2">
                                            <div class="input-cont mb-2">
                                                <textarea class="input-box" name="message" id="message" cols="30" rows="3" required></textarea>
                                                <label class="input-label">Input Message Deficiency</label>
                                            </div>
                                        
                                            
                                            <input type="hidden" name="signatory_id" value="<?php echo $user_data['id']; ?>">
                                            <input type="hidden" name="clearance_id" value="<?php echo $_GET['clearance_id']; ?>">
                                            <input type="hidden" name="semester" value="<?php echo $clearanceInfo['semester'] ?>">
                                            <input type="hidden" name="academic_year" value="<?php echo $clearanceInfo['academic_year'] ?>">
                                            <input type="hidden" name="url_info_string" value="<?php echo 'clearance_id='. $_GET['clearance_id'] .'&workplace='. $_GET['workplace'] .'&designation_workplace= '. $_GET['designation_workplace'] ?>">
                                            <input type="hidden" name="designation_table" value="<?php echo $_GET['designation_workplace']; ?>">


                                            <div class="success-notice f-s my-2"><i class="fal fa-question-circle"></i> Note: This will add deficiencies simultaneously to those included in chosen file , please review your action before proceeding.</div>
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

            

            <script>      
                $(document).ready(function(){

                    $('#my-datable tbody').on('click', '.view-clearance', function(){
                        let student_id = $(this).attr('data-id');
                        let claerance_id = $(this).attr('data-value');
                        $.ajax({
                            type: "POST",
                            url: "../controller/clearance_admin_view.php",
                            data: {
                                student_id : student_id,
                                clearance_id : claerance_id,
                            },
                            success: function(result) {
                                console.log(result);
                                $('#studentClearanceData').html(result);
                            }
                        })
                    });

                    $('#my-datable tbody').on('click', '.view-btn', function(){

                        let sid = $(this).attr('data-id');
                        let sigid = $('#sigid').val();
                        let cid = $(this).attr('data-cl-id');
                        let table = $(this).attr('data-cl-table');
                        let name = $(this).attr('data-value');
                        let yearLevel = $(this).attr('data-value1');
                        let programCourse = $(this).attr('data-value2');
                        $('#m-rec-text').text(sid);
                        $('#m_student_id').val(sid);
                        $('#m-name-text').text(name);
                        $('#m-yc-text').text(programCourse + " - " + yearLevel);

                        $.ajax({
                            type: "POST",
                            url: "../controller/signatory_deficiency_view.php",
                            data: {
                                student_id : sid,
                                clearance_id : cid,
                                designation_table: table,
                            },
                            success: function(result) {
                                console.log(result);
                                $('#msg-area').html(result);
                            }
                        })
                        
                    });

                    
                   

                    // $('#printReport').click(function() {
                    //     var clearance_id = '<?php //echo $_GET['clearance_id']; ?>';
                    //     var designation_table = '<?php //echo //$_GET['designation_workplace']; ?>';
                    //     $.ajax({
                    //         url: 'student_clearance_report.php',
                    //         type: "GET",
                    //         data: {clearance_id: clearance_id,
                    //                designation_table: designation_table
                    //             },
                    //         success: function(response) {
                    //             // Create a new window and write the response content to it
                    //             let printWindow = window.open('', 'Print Window');
                    //             printWindow.document.write(response);

                    //             // Wait for the new window to finish loading before calling the print() function
                                
                    //             setTimeout(function(){
                    //                 printWindow.print();
                    //                 // Close the new window
                    //                 printWindow.close();
                    //             }, 1000);
                    //         }
                    //     });
                    // });
                })
               
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>