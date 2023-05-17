<?php 
    require_once '../includes/main_header.php' 
?>
<style>
    body {
        background-color: #f8f9fa;
    }
</style>

<div class="page px-4 py-3">
    <!-- <div class="alert alert-dismissible alert-light" id='err'>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>WABCMS 2.0</strong> <span></span>
    </div> -->
    <div class="d-flex justify-content-between mb-2 align-items-center">
        <h1 class="page-title fs-5 display-6 ">Dashboard </h1>
        <div class="f-d badge bg-success rounded" data-bs-toggle="tooltip" title="Clearance Reference Number">A.Y 2022-2023</div>
    </div>

    <div class="d-grid">

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Students</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allStudents(); ?></span>
                <div class="s-card-pic">
                    <img class=" p-2 rounded-circle bg-light" src="https://festisso.sirv.com/wabcms_images/multiple-users-silhouette.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a class="text-decoration-none f-s text-accent" href="#">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Signatories</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->assignedSignatories(); ?></span>
                <div class="s-card-pic">
                    <img class=" p-2 rounded-circle bg-light" src="https://festisso.sirv.com/wabcms_images/writing.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a class="text-decoration-none f-s text-accent" href="#">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Designations</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allDesignation(); ?></span>
                <div class="s-card-pic ">
                    <img class=" p-2 bg-light rounded-circle" src="https://festisso.sirv.com/wabcms_images/man-working-on-a-laptop-from-side-view.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a class="text-decoration-none f-s text-accent" href="#">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Clearance</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allClearance(); ?></span>
                <div class="s-card-pic ">
                    <img class=" p-2 bg-light rounded-circle" src="https://festisso.sirv.com/wabcms_images/copy.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a class="text-decoration-none f-s text-accent" href="#">View Information</a>
            </div>
        </div>
    </div>
    

    
    <!-- <div class="bg-white rounded py-3 px-3 mb-2 ">
    </div> -->

    <div class="d-workplace px-3 py-2 pb-3 mt-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="f-d">Workplace</div>
            <div class="info-btn">
                <i class="fal fa-info-circle"></i>
            </div>
        </div>
        <div class="px-2 bg-white rounded py-1">
            <?php 
                $workplace = $dashboard->getWorkplace();
            ?>
            <table class="table table-borderless">
                <tr>
                    <td> Organizations </td>
                    <td><?php echo $workplace['org_count'] ?></td>
                </tr>
                <tr>
                    <td> Department </td>
                    <td><?php echo $workplace['dept_count'] ?></td>
                </tr>
                <tr>
                    <td> Offices </td>
                    <td><?php echo $workplace['ofc_count'] ?></td>
                </tr>
                <tr>
                    <td> SHS </td>
                    <td><?php echo $workplace['shs_count'] ?></td>
                </tr>
                
            </table>
        </div>
    </div>
</div>
   
<?php require_once '../includes/main_footer.php' ?>