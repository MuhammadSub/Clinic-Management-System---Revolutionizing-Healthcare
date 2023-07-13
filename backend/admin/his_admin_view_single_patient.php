<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid = $_SESSION['ad_id'];
?>

<!DOCTYPE html>
<html lang="en">
    <style>
		.transparent {
			opacity: 0;
		}
	</style>
<?php include('assets/inc/head.php');?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php");?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php");?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!--Get Details Of A Single User And Display Them Here-->
        <?php
            $pat_number = $_GET['pat_number'];
            $pat_id = $_GET['pat_id'];
            $ret = "SELECT * FROM his_patients WHERE pat_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $pat_id);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {
                $mysqlDateTime = $row->pat_date_joined;
        ?>
        <div class="content-page">
            <div class="content">

                <!-- Start Content -->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                        <li class="breadcrumb-item active">View Patients</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>'s Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                <div class="text-left mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->pat_phone;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row->pat_addr;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->pat_dob;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Age :</strong> <span class="ml-2"><?php echo $row->pat_age;?> Years</span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Ailment :</strong> <span class="ml-2"><?php echo $row->pat_ailment;?></span></p>
                                    <hr>
                                    <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:m", strtotime($mysqlDateTime));?></span></p>
                                    
                                </div>
								 <hr>
                                 <!-- Print Button -->
                                 <button class="btn btn-primary print-button align-content-center" onclick="printPage()"><i class="mdi mdi-printer mr-1"></i> Print</button>
                            </div> <!-- end card-box -->
                        </div> <!-- end col-->

                        <?php }?>
                        <div class="col-lg-8 col-xl-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Prescription
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                            Vitals
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            Lab Records
                                        </a>
                                    </li>
                                </ul>
                                <!-- Medical History -->
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="aboutme">
                                        <div class="card-body">
                                            <?php
                                                $pres_pat_number = $_GET['pat_number'];
                                                $ret = "SELECT * FROM his_prescriptions WHERE pres_pat_number ='$pres_pat_number'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                
                                                while ($row = $res->fetch_object()) {
                                                    $mysqlDateTime = $row->pres_date; //trim timestamp to date
                                            ?>
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></h5>
                                                    <p class="card-text"><?php echo $row->pres_pat_ailment;?></p>
                                                    <p class="card-text text-muted"><?php echo $row->pres_ins;?></p>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div> <!-- end tab-pane -->
                                    <!-- end Prescription section content -->

                                    <div class="tab-pane show " id="timeline">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Body Temperature</th>
                                                        <th>Heart Rate/Pulse</th>
                                                        <th>Respiratory Rate</th>
                                                        <th>Blood Pressure</th>
                                                        <th>Date Recorded</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $vit_pat_number = $_GET['pat_number'];
                                                        $ret = "SELECT * FROM his_vitals WHERE vit_pat_number ='$vit_pat_number'";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();

                                                        while ($row = $res->fetch_object()) {
                                                            $mysqlDateTime = $row->vit_daterec; //trim timestamp to date
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row->vit_bodytemp;?>°C</td>
                                                        <td><?php echo $row->vit_heartpulse;?>BPM</td>
                                                        <td><?php echo $row->vit_resprate;?>bpm</td>
                                                        <td><?php echo $row->vit_bloodpress;?>mmHg</td>
                                                        <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end vitals content-->

                                    <div class="tab-pane" id="settings">
                                        <div class="card-body">
                                            <?php
                                                $lab_pat_number = $_GET['pat_number'];
                                                $ret = "SELECT * FROM his_laboratory WHERE lab_pat_number  = '$lab_pat_number'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute();
                                                $res = $stmt->get_result();

                                                while ($row = $res->fetch_object()) {
                                                    $mysqlDateTime = $row->lab_date_rec; //trim timestamp to date
                                            ?>
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></h5>
                                                    <h5 class="card-title"><?php echo $row->lab_pat_ailment;?></h5>
                                                    <hr>
                                                    <h5>Laboratory Tests</h5>
                                                    <p class="card-text"><?php echo $row->lab_pat_tests;?></p>
                                                    <hr>
                                                    <h5>Laboratory Results</h5>
                                                    <p class="card-text"><?php echo $row->lab_pat_results;?></p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <!-- end lab records content-->
                                </div> <!-- end tab-content -->
                            </div> <!-- end card-box-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row-->
                </div> <!-- container -->
            </div> <!-- content -->
            <!-- Footer Start -->
            <?php include('assets/inc/footer.php');?>
            <!-- end Footer -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JavaScript function for printing -->
    <script>
			function printPage() {
				// Add a class to the button to make it transparent
				document.querySelector('.print-button').classList.add('transparent');

				// Perform the printing action
				window.print();
			}

			// Listen for the 'afterprint' event and remove the transparent class from the button
			window.addEventListener('afterprint', function() {
				document.querySelector('.print-button').classList.remove('transparent');
			});
		</script>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>
