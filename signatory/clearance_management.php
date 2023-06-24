<?php 
    require_once '../includes/main_header.php'; 

    $activeClearance = $clearance->getActiveClearanceSignatories();
    $previousClearance = $clearance->getPreviousClearanceSignatories();
    
    $user_data = $_SESSION['user_data'];
    
?>
    <div class="page px-4">
        <?php if(isset($_GET['success'])){ echo '<div class="alert alert-success" id="err">Clearance has been created.</div>'; } ?>
        <?php if(isset($_GET['delete'])){ echo '<div class="alert alert-success" id="err">Clearance has been deleted.</div>'; } ?>
        <div class="d-flex justify-content-between align-items-center m-0">
            <h1 class="fs-6 display-6 m-0"><i class="fas fa-th-list text-success me-1"></i> Active Clearance</h1>
            <div class="dropdown">
                <div class="setoptions" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </div>
                <ul class="dropdown-menu">
                    <li><button id="showArch" class="dropdown-item" href="#">Show Archive</button></li>
                    <li><button id="hideArch" class="dropdown-item" href="#">Hide Archive</button></li>
                </ul>
            </div>
            
        </div>
        <div class="page-content p-2 pt-0 rounded x-border position-relative" style="max-height: 80vh; height: 90vh; padding-top: 10px;">
           
            <div class="card-grid">
                <?php foreach($activeClearance as $ac_signatory): ?>
                <div class="clearance-card">
                    <div class="cl-card-header">
                        <h1 class="f-d m-0 pb-1"><?php echo $ac_signatory['clearance_name'] ?></h1>
                        <h1 class="f-s display-6"><em><?php echo date("M j, Y h:i A", strtotime($ac_signatory['date_deploy_signatory'])); ?></em></h1>
                    </div>

                    <div class="cl-card-body pt-1 pb-2">
                        <h1 class="fs-6 display-6 text-center"><?php echo $ac_signatory['clearance_name'] ?> - <?php echo $ac_signatory['semester'] ?> A.Y. <?php echo $ac_signatory['academic_year'] ?></h1>
                    </div>

                    <div class="cl-card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <button data-id="<?php echo $ac_signatory['clearance_id'] ?>" class="btn btn-view btn-sm btn-success rounded btnsm w-50" data-bs-toggle="modal" data-bs-target="#designationModal">View</button>
                            <div class="info-btn">
                                <i class="fal fa-info-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="b-pc" id="archive">
                <hr class="mt-5 mb-3" stype="box-sizing: border-box;">
                <h1 class="fs-6 display-6 pb-1 mb-2"><i class=" fa-solid fa-clock-rotate-left me-2"></i>Previous Clearance</h1>
                <div class="card-grid">
                    <?php foreach($activeClearance as $ac_signatory): ?>
                    <div class="clearance-card clearance-card-inactive ">
                        <div class="cl-card-header">
                            <h1 class="f-d m-0 pb-1"><?php echo $ac_signatory['clearance_name'] ?></h1>
                            <h1 class="f-s display-6"><em><?php echo date("M j, Y h:i A", strtotime($ac_signatory['date_deploy_signatory'])); ?></em></h1>
                        </div>

                        <div class="cl-card-body pt-1 pb-2">
                            <h1 class="fs-6 display-6 text-center"><?php echo $ac_signatory['clearance_name'] ?> - <?php echo $ac_signatory['semester'] ?> A.Y. <?php echo $ac_signatory['academic_year'] ?></h1>
                        </div>

                        <div class="cl-card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <button data-id="<?php echo $ac_signatory['clearance_id'] ?>" class="btn btn-view btn-sm btn-secondary rounded btnsm w-50" data-bs-toggle="modal" data-bs-target="#designationModal">View</button>
                                <div class="info-btn">
                                    <i class="fal fa-info-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
                        <div class="modal-body x-border" id="designation-content">
                            
                        </div>
                        <div class="d-flex justify-content-end my-2 mb-3 gap-2 px-3"> 
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                    $('#archive').hide();
                    $('#showArch').click(function(){
                        $('#archive').show();
                    })

                    $('#hideArch').click(function(){
                        $('#archive').hide();
                    })
                });
            </script>

            <script>      
                $(document).ready(function(){
                    $('.btn-view').on('click', function(){
                        let signatoryId = '<?php echo $user_data['id']?>';
                        let clearanceId = $(this).attr('data-id');
                       $.ajax({
                            type: "POST",
                            url: "../controller/signatory_designations.php",
                            data: {
                                signatory_id: signatoryId,
                                clearance_id: clearanceId
                            },
                            success: function(response) {
                                if(response.length !== 0) {
                                    $('#designation-content').html(response);
                                }else {
                                    $('#designation-content').html('<h1 class="display-6 fs-6 text-center text-success">    You do not have designation assigned to you.</h1>');
                                }
                            }
                       })
                    })
                })
               
            </script>
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>