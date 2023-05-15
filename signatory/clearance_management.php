<?php 
    require_once '../includes/main_header.php'; 

    $clearanceTypes = $clearance->getClearanceType();
    $clearances = $clearance->getAllClearance();
    $beneficiaries = $clearance->getBeneficiaries();
?>
    <div class="page">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <h1 class="page-title fs-5 display-6">Clearance List</h1>
        <div class="page-content p-2 rounded ">
            <div>
                <div class="clearance-card">
                    <div class="cl-card-header">
                        <h1 class="f-d m-0">Finals Clearance</h1>
                        <h1 class="f-s display-6">May 15, 2023</h1>
                    </div>

                    <div class="cl-card-body pt-1 pb-2">
                        <h1 class="fs-6 display-6 text-center">Finals Clearance - 2nd Semester A.Y. 2022-2023</h1>
                    </div>

                    <div class="cl-card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <button data-id="<?php echo $office_row['id']?>" class="btn btn-view btn-sm btn-success rounded btnsm w-50" data-bs-toggle="modal" data-bs-target="#designationModal">View</button>
                            <div class="info-btn">
                                <i class="fal fa-info-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade custom-modal " id="designationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header x-border py-0 pt-3 d-flex align-items-center mb-3">
                            <h1 class="display-6 fs-5 m-0">Your Designation</h1>
                            <!-- <i class="fal fa-times fs-2"></i> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body x-border">
                            <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                <button type="button" class="btn btn-outline-success rounded py-3 px-5 w-75" data-bs-dismiss="modal"><span class="badge bg-success mx-2">1</span> BSIS PROGRAM HEAD</button>
                                <button type="button" class="btn btn-outline-success rounded py-3 px-5 w-75" data-bs-dismiss="modal"><span class="badge bg-success mx-2">2</span> LIBRARIAN</button>
                                
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-2 mb-3 gap-2 px-3"> 
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>      

               
            </script>
        
            
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>