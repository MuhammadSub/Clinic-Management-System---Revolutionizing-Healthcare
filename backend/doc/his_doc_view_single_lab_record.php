<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $doc_id = $_SESSION['doc_id'];
?>
<!DOCTYPE html>
<html lang="en">
     <style>
		.transparent {
			opacity: 0;
		}
	</style>
<?php include ('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $lab_number=$_GET['lab_number'];
                $lab_id=$_GET['lab_id'];
                $ret="SELECT  * FROM his_laboratory WHERE lab_id = ?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$lab_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
                    $mysqlDateTime = $row->lab_date_rec;
            ?>

                <div class="content-page">
                    <div class="content">

                        <!-- Start Content-->
                        <div class="container-fluid">
                            
                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratory Records</a></li>
                                                <li class="breadcrumb-item active">View  Records</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">#<?php echo $row->lab_number;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-xl-5">

                                                <div class="tab-content pt-0">

                                                    <div class="tab-pane active show" id="product-1-item">
                                                        <img src="assets/images/medical_record.png" alt="" class="img-fluid mx-auto d-block rounded">
                                                    </div>
                            
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-xl-7">
                                                <div class="pl-xl-3 mt-3 mt-xl-0">
                                                    <h2 class="mb-3">Patient's Name : <?php echo $row->lab_pat_name;?></h2>
                                                    <hr>
                                                    <h3 class="text-danger ">Patient Number : <?php echo $row->lab_pat_number;?></h3>
                                                    <hr>
                                                    <h3 class="text-danger ">Patient Ailment : <?php echo $row->lab_pat_ailment;?></h3>
                                                    <hr>
                                                    <h3 class="text-danger ">Date Recorded : <?php echo date("d/m/Y - h:m:s", strtotime($mysqlDateTime));?></h3>
                                                    <hr>
                                                    <h2 class="align-centre">Laboratory Test</h2>
                                                    <hr>
                                                    <p class="text-muted mb-4">
                                                        <?php echo $row->lab_pat_tests;?>
                                                    </p>
                                                    <hr>
                                                    <h2 class="align-centre">Laboratory Result</h2>
                                                    <p class="text-muted mb-4">
                                                        <?php echo $row->lab_pat_results;?>
                                                    </p>
                                                    <hr>
													<button class="btn btn-primary print-button align-content-center" onclick="printPage()"><i class="mdi mdi-printer mr-1"></i> Print</button>
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->
                            
                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                        <?php include('assets/inc/footer.php');?>
                    <!-- end Footer -->

                </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

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

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>