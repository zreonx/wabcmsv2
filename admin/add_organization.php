<?php require_once '../includes/main_header.php' ?>
    <div class="page">
        <h1 class="page-title fs-5 display-6">Organization Management</h1>
        <div class="page-content p-2 rounded ">
            <div class="row">
                <div class="col-lg-5 pt-2 px-4">
                    <label class="form-label">Manage Organizations</label>
                    <div class="p-1 px-3">
                        <div class="input-cont rounded mb-3">
                            <input type="text" id="organization_code" class="input-box" required>
                            <label class="input-label">Organization Acronym</label>
                        </div>
                        <div class="input-cont">
                            <input type="text" id="organization_name" class="input-box" required>
                            <label class="input-label">Organization Name</label>
                        </div>
                        <div class="btn btn-success rounded mt-3" id="addOrgBtn">Add Organization</div>
                    </div>
                </div>
                <div class="col-lg-7 pt-2 px-4">
                    <label class="form-label">Organizations</label>
                    <div class="custom-table default-height-overflow">

                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){

                    setInterval(function() {
                        $('.custom-table').load('organization_table.php')
                    }, 1000)
                    
                    $('#addOrgBtn').click( function (){
                        let orgCode = $('#organization_code').val()
                        let orgName = $('#organization_name').val()

                        console.log(orgCode.length);

                        if(orgCode.length !== 0 || orgName.length !== 0) {
                            $.ajax({
                                method : "POST",
                                url: "../controller/add_org.php",
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
                    })
                    
                })
            </script>
        </div>
    </div>
<?php require_once '../includes/main_footer.php' ?>