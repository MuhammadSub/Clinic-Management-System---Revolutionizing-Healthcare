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
	.img-max-width {
    max-width: 400px;
		max-height: 400px;
	}
</style>
	
<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('assets/inc/nav.php'); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <?php
        $doc_number = $_GET['doc_number'];
        $doc_id = $_GET['doc_id'];
        $ret = "SELECT * FROM his_docs WHERE doc_number = ? AND doc_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('ii', $doc_number, $doc_id);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_object()) {
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
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Doctor</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">#<?php echo $row->doc_number; ?></h4>
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
													<?php
													$imagePath = 'assets/images/users/1.png';
													if (file_exists($imagePath)) {
														echo '<img src="' . $imagePath . '" alt="" class="img-fluid mx-auto d-block rounded">';
													} else {
														echo 'Image not found: ' . $imagePath;
													}
													?>
												</div>
											</div>
										</div> <!-- end col -->
                                        <div class="col-xl-7">
                                            <div class="pl-xl-3 mt-3 mt-xl-0">
                                                <h2 class="mb-3">Doctor Name: <?php echo $row->doc_fname; ?> <?php echo $row->doc_lname; ?></h2>
                                                <hr>
                                                <h3 class="text-danger">Doctor Number: <?php echo $row->doc_number; ?></h3>
                                                <hr>
                                                <h3 class="text-danger">Doctor Department: <?php echo $row->doc_dept; ?></h3>
                                                <hr>
												<h3 class="text-danger">Doctor Email: <?php echo $row->doc_email; ?></h3>
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
                <?php include('assets/inc/footer.php'); ?>
                <!-- end Footer -->

            </div>
        <?php } ?>

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
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
