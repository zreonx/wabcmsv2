<?php 
    require_once '../includes/main_header.php' ;

    $active_claerance = $dashboard->getActiveClearance();
    $current_year = date('Y');
    $prev_year = $current_year - 1;
    $next_year = date('Y', strtotime($current_year . ' +1 year'));

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
        <div class="f-d badge bg-success rounded" data-bs-toggle="tooltip" title="Academic Year"><?php echo $prev_year ?>-<?php echo $current_year ?></div>
    </div>

    <div class="d-grid">

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Students</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allStudents(); ?></span>
                <div class="s-card-pic">
                    <img class=" p-2 rounded-circle bg-light" src="https://zreonph.sirv.com/wabcms_images/multiple-users-silhouette.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a href="student_management.php" class="text-decoration-none f-s text-accent">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Signatories</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->assignedSignatories(); ?></span>
                <div class="s-card-pic">
                    <img class=" p-2 rounded-circle bg-light" src="https://zreonph.sirv.com/wabcms_images/writing.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a href="signatory_management.php" class="text-decoration-none f-s text-accent">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Designations</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allDesignation(); ?></span>
                <div class="s-card-pic ">
                    <img class=" p-2 bg-light rounded-circle" src="https://zreonph.sirv.com/wabcms_images/man-working-on-a-laptop-from-side-view.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a href="add_designation_information.php" class="text-decoration-none f-s text-accent">View Information</a>
            </div>
        </div>

        <div class="d-card py-2 px-2 position-relative">
            <h1 class="text-gray f-d m-1 mt-0">Clearance</h1>
            <div class="d-flex justify-content-evenly">
                <span class="fs-3"><?php echo $dashboard->allClearance(); ?></span>
                <div class="s-card-pic ">
                    <img class=" p-2 bg-light rounded-circle" src="https://zreonph.sirv.com/wabcms_images/copy.png" style="height: 42px;" alt="">
                </div>
            </div>
            <div class="d-overlay position-absolute w-100" >
                <a href="clearance_management.php" class="text-decoration-none f-s text-accent">View Information</a>
            </div>
        </div>
    </div>
    

    
    <!-- <div class="bg-white rounded py-3 px-3 mb-2 ">
    </div> -->

    <div class="d-charts d-flex gap-2">
        
        <div class="mt-3 py-2 pb-3 bg-white p-4 w-25 w-r-100">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="f-d">Workplace</div>
                <div class="info-btn">
                    <i class="fal fa-info-circle"></i>
                </div>
            </div>
            <div class="px-2 rounded py-1">
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
        <?php if(!empty($active_claerance) && $active_claerance['clearance_name'] == "Finals Clearance"): ?>
        <div class=" flex-grow-1 p-3 d-none">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="fs-6 text-success">Active Clearance <i class="fas fa-check-circle pt-1 fs-5"></i></div>
                <div class="f-d badge bg-success rounded" data-bs-toggle="tooltip" title="Clearance Reference Number">CRN  <?php echo $active_claerance['clearance_id']; ?></div>
            </div>
            <div class="dc-overview d-flex gap-3">
                <div class="d-workplace px-3 py-2 pb-3 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="f-d">Workplace</div>
                        <div class="info-btn">
                            <i class="fal fa-info-circle"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded py-1">
                        <div id="my-bar"></div>
                        <!-- <canvas id="myChartBar"></canvas> -->
                    </div>
                </div>
            </div>
            <div>
                <div class="px-3 py-2 pb-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="f-d">Clearance Status</div>
                        <div class="info-btn">
                            <i class="fal fa-info-circle"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column bg-white rounded py-2">
                        <!-- <canvas id="myChartPie"></canvas> -->

                        <div id="my-pie"></div>
                        <div class="mt-2 mx-2 text-center">Total Student: <span id="total_pie">200</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
</div>

<script>
        
    $(document).ready(function(){
        
        var all_signatory;
        var active_clearance = '<?php echo $active_claerance['clearance_id']; ?>';

        $.ajax({
            method : "POST",
            url: "../controller/dashboard_all_signatories.php",
            data: {
                key : "key",
            },
            success: function(result) {
                all_signatory = JSON.parse(result);

                $.ajax({
                    method : "POST",
                    url: "../controller/dashboard_all_signatory_progress.php",
                    data: {
                        key : "key",
                        clearance_id: active_clearance,
                    },
                    success: function(result) {
                        let sig_percentage = JSON.parse(result);
                        console.log(sig_percentage);

                        var sig_decimals = sig_percentage.map(function(percent) {
                            return percent / 100;
                        });


                        var data = [
                            {
                                x: all_signatory,
                                y: sig_decimals,
                                type: 'bar',
                                marker: {
                                    color: 'limegreen',
                                }
                            }
                        ];

                        var layout = {
                            yaxis: {
                                tickformat: ',.0%',
                            }
                        };

                        Plotly.newPlot('my-bar', data, layout);

                        
                    }
                })

                
            }
        })


        $.ajax({
            method : "POST",
            url: "../controller/dashboard_signatory_status.php",
            data: {
                key : "key",
                clearance_id: active_clearance,
            },
            success: function(result) {
 
                var pie_status = JSON.parse(result);
                $('#total_pie').html(pie_status['total']);

                var data = [{
                    type: "pie",
                    values: [pie_status['cleared'], pie_status['deficient'], pie_status['unsigned']],
                    labels: ["Cleared", "Deficient", "Unsigned"],
                    textinfo: "label+percent",
                    textposition: "outside",
                    automargin: true
                    }]

                    var layout = {
                    height: 400,
                    width: 400,
                    margin: {"t": 0, "b": 0, "l": 0, "r": 0},
                    showlegend: false
                    }

                Plotly.newPlot('my-pie', data, layout)
            }
        })

       

       


        
        
    });
</script>
   
<?php require_once '../includes/main_footer.php' ?>