<?php 
    require_once '../includes/main_header.php'; 
    require_once '../config/connection.php';
    $user_data = $_SESSION['user_data'];

    $midinit = strtoupper(substr($user_data['middle_name'], 0, 1)) . ". ";

    $midname = ($user_data['middle_name'] == '') ? ' ' : $midinit;

?> 

    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
    <div class="page position-relative">
        
        <?php if(isset($_GET['old_pass_match'])){ echo '<div class="popup-message"><div class="alert alert-danger shadow-xl" role="alert">The password you have entered does not match to your current password!</div>'; } ?>
        <?php if(isset($_GET['confirm_pass_match'])){ echo '<div class="popup-message"><div class="alert alert-danger shadow-xl" role="alert">Confirm password does not match!</div>'; } ?>
        <?php if(isset($_GET['change_pass']) && $_GET['change_pass'] == 'success'){ echo '<div class="popup-message"><div class="alert alert-success shadow-xl" role="alert">Password Changed Successfully!</div>'; } ?>
        </div>
        <h1 class="page-title fs-5 display-6 mx-3">Settings</h1>
        <div class="page-content rounded x-border">
        <div class="account-setting p-3 py-0">
            <div class="row shadow-m py-3 px-2 rounded" style="background-color: #fff;">
                <div class="col">
                    <h1 class="fs-6 display-6 mb-2">Personal Information</h1>
                    <div class="form-group mb-2">
                        <label class="form-label mb-0 f-d">Name</label>
                        <input type="text" class="form-control form-control-sm py-2 px-3" value="<?php echo $user_data['first_name'] . " " . $midname . $user_data['last_name'] ;?>" disabled>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label mb-0 f-d">Email</label>
                        <input type="text" class="form-control form-control-sm py-2 px-3" value="<?php echo $user_data['email'];?>" disabled>
                    </div>
                </div>
            </div>

            <div class="row shadow-m py-3 px-2 rounded mt-4" style="background-color: #fff;">
                <div class="col">
                    <h1 class="fs-6 display-6 mb-2">Change Your Password</h1>
                    <form action="../controller/user_change_password.php" method="POST">
                        <div class="p-2 w-50 pwf">
                            <input type="hidden" name="user_id" value="<?php echo $user_data['admin_id']; ?>">
                            <input type="hidden" name="user_type" value="<?php echo $_SESSION['user_type']; ?>">
                            <div class="input-cont mb-3">
                                <input type="password" id="description" name="old_password" class="input-box" required>
                                <label class="input-label">Old Password</label>
                            </div>
                            <div class="input-cont mb-3">
                                <input type="password" id="description" name="new_password" class="input-box" required>
                                <label class="input-label">New Password</label>
                            </div>
                            <div class="input-cont mb-2">
                                <input type="password" id="description" name="confirm_password" class="input-box" required>
                                <label class="input-label">Confirm Password</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success rounded mt-2">Change Password</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <div class="modal fade custom-modal " id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <div class="modal-header x-border py-1 pt-3">
                        <h1 class="px-1 display-6 fs-5">Delete Organization</h1>
                    </div>
                    <div class="modal-body x-border py-0">
                        <div class="d-flex gap-2justify-content-center align-items-center danger-notice p-3">
                            <div class="fs-1 text-danger p-2">
                                <i class="fas fa-trash"></i>
                            </div>
                            <div class="p-2 f-d">Notice! This action cannot be undone. Are you sure you want to delete this organization?</div>
                        </div>
                        <div class="d-flex justify-content-end my-2 mb-3 gap-2">
                            <button id="removeSignatory" class="btn btn-danger rounded confirm-remove">Confirm</button>
                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

        <script>
            $(document).ready(function(){
                $('.popup-message').animate({opacity: 1}, 800)
                setTimeout(function(){
                    $('.popup-message').animate({opacity: 0}, 800, function() {
                        $(this).remove();
                    });
                },3000);
            })
        </script>
    </div>
<?php require_once '../includes/main_footer.php' ?>