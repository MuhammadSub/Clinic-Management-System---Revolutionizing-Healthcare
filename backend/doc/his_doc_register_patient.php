<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add_patient']))
		{
			$pat_fname=$_POST['pat_fname'];
			$pat_lname=$_POST['pat_lname'];
			$pat_number=$_POST['pat_number'];
            $pat_phone=$_POST['pat_phone'];
            $pat_type=$_POST['pat_type'];
            $pat_addr=$_POST['pat_addr'];
            $pat_age = $_POST['pat_age'];
            $pat_dob = $_POST['pat_dob'];
            $pat_ailment = $_POST['pat_ailment'];
            //sql to insert captured values
			$query="insert into his_patients (pat_fname, pat_ailment, pat_lname, pat_age, pat_dob, pat_number, pat_phone, pat_type, pat_addr) values(?,?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssssss', $pat_fname, $pat_ailment, $pat_lname, $pat_age, $pat_dob, $pat_number, $pat_phone, $pat_type, $pat_addr);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Details Added";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">Add Patient</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Patient Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="inputEmail4" class="col-form-label">First Name</label>
													<input type="text" required="required" name="pat_fname" class="form-control" id="inputEmail4" placeholder="Patient's First Name">
												</div>
												<div class="form-group col-md-6">
													<label for="inputPassword4" class="col-form-label">Last Name</label>
													<input required="required" type="text" name="pat_lname" class="form-control" id="inputPassword4" placeholder="Patient's Last Name">
												</div>
											</div>

											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="inputDOB" class="col-form-label">Date Of Birth</label>
													<input type="date" required="required" name="pat_dob" class="form-control" id="inputDOB" placeholder="DD/MM/YYYY">
												</div>
												<div class="form-group col-md-6">
													<label for="inputAge" class="col-form-label">Age</label>
													<input required="required" type="number" name="pat_age" class="form-control" id="inputAge" placeholder="Patient's Age" min="0">
												</div>
											</div>

											<div class="form-group">
												<label for="inputAddress" class="col-form-label">Address</label>
												<input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress" placeholder="Patient's Address">
											</div>

											<div class="form-row">
												<div class="form-group col-md-4">
													<label for="inputPhone" class="col-form-label">Mobile Number</label>
													<input required="required" type="tel" name="pat_phone" class="form-control" id="inputPhone" pattern="[0-9]{11}" maxlength="11" placeholder="XXXXXXXXXXX">
												</div>
												<div class="form-group col-md-4">
													<label for="inputAilment" class="col-form-label">Patient Ailment</label>
													<input required="required" type="text" name="pat_ailment" class="form-control" id="inputAilment">
												</div>
												<div class="form-group col-md-4">
													<label for="inputType" class="col-form-label">Patient's Type</label>
													<select id="inputType" required="required" name="pat_type" class="form-control">
														<option disabled selected>Choose</option>
														<option>InPatient</option>
														<option>OutPatient</option>
													</select>
												</div>
												<div class="form-group col-md-2" style="display:none">
													<?php 
														$length = 5;    
														$patient_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
													?>
													<label for="inputZip" class="col-form-label">Patient Number</label>
													<input type="text" name="pat_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
												</div>
											</div>

											<button type="submit" name="add_patient" class="ladda-button btn btn-primary" data-style="expand-right">Add Patient</button>
										</form>

                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

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

		<script>
			// Mobile Number validation
			var phoneInput = document.getElementById("inputPhone");
			phoneInput.addEventListener("input", function () {
				var phone = phoneInput.value;
				var phoneRegex = /^\d{11}$/;

				if (!phoneRegex.test(phone)) {
					phoneInput.setCustomValidity("Please enter a valid 11-digit mobile number");
				} else {
					phoneInput.setCustomValidity("");
				}
			});
		</script>
		
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>