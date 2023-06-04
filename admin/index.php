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

    <div class="d-charts d-flex gap-3">
        
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
        <div class="mt-3 flex-grow-1 p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="fs-6 text-success">Active Clearance <i class="fas fa-check-circle pt-1 fs-5"></i></div>
                <div class="f-d badge bg-success rounded" data-bs-toggle="tooltip" title="Clearance Reference Number">CRN 12</div>
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
                        <canvas id="myChartBar"></canvas>
                    </div>
                </div>

                <div class="d-workplace px-3 py-2 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="f-d">Clearance Status</div>
                        <div class="info-btn">
                            <i class="fal fa-info-circle"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded py-1">
                    <canvas id="myChartPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    $(document).ready(function(){
        var barGraph = document.getElementById('myChartBar').getContext('2d');
		var myChartBar = new Chart(barGraph, {
		    type: 'bar',
		    data: {
		        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
		        datasets: [{
		            label: 'Sales',
		            data: [1500, 1200, 1800, 2000, 1300, 1900],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true
		                }
		            }]
		        }
		    }
		});


        var pieGraph = document.getElementById('myChartPie').getContext('2d');

		var myChartPie = new Chart(pieGraph, {
			type: 'pie',
			data: {
				labels: ['Defficient', 'Cleared', 'Unsigned'],
				datasets: [{
					label: '# of Votes',
					data: [12, 19, 3],
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		});
        
    });
</script>
   
<?php require_once '../includes/main_footer.php' ?>