<?php
require_once 'includes/classes/db-connector.php';
require_once 'includes/session-handler.php';
require_once 'includes/classes/session-manager.php';

if (isset($_SESSION['voter_id'])) {

	$voter_id = $_GET['voter_id'];

	// ------ SESSION EXCHANGE
	include 'includes/session-exchange.php';
	// ------ END OF SESSION EXCHANGE

	$conn = DatabaseConnection::connect();
	$voter_query = "SELECT * FROM voter WHERE voter_id = $voter_id";
	$result = $conn->query($voter_query);
	$row = $result->fetch_assoc();
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/x-icon" href="images/resc/ivote-favicon.png">
		<title>Manage Account</title>

		<!-- Icons -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

		<!-- Styles -->
		<link rel="stylesheet" href="<?php echo 'styles/orgs/' . $org_name . '.css'; ?>" id="org-style">
		<link rel="stylesheet" href="styles/style.css" />
		<link rel="stylesheet" href="styles/core.css" />
		<link rel="stylesheet" href="styles/manage-voters.css" />
		<link rel="stylesheet" href="../vendor/node_modules/bootstrap/dist/css/bootstrap.min.css" />

	</head>

	<body>

		<?php include_once __DIR__ . '/includes/components/sidebar.php'; ?>

		<div class="main">
			<!-- Breadcrumbs -->
			<div class="container">
				<div class="row">
					<div class="col-md-8">Placeholder for bread crumbs</div>
				</div>
			</div>

			<div class="container-wrapper">
				<div class="container mt-xl-3">
					<div class="container-fluid">
						<div class="row justify-content-center">
							<div class="col-md-11">
								<div class="card-box">
									<div class="row">

										<!-- FIRST COLUMN -->
										<div class="col-md-7 p-sm-5">
											<!-- Header of Left Column -->
											<div class="row">
												<!-- COR Name -->
												<div class="col-md-6 d-flex flex-row">
													<p class="fw-bold fs-7">
														<i class="fas fa-paperclip fa-sm"></i>
														<span class="ps-sm-1 spacing-5"><?php echo $row["cor"] ?></span>
													</p>
												</div>
												<!-- Download + Full Screen Name -->
												<div class="col-md-6 d-flex flex-row-reverse">
													<div class="row funcs">
														<div class="col-md-10">
															<!-- Download -->
															<a href="<?php echo "user_data/$org_name/cor/" . $row['cor']; ?>"
																download>
																<p class="fs-7 d-flex align-items-center">
																	<i data-feather="download" class="feather-sm"></i>
																	<span
																		class="ps-sm-2 spacing-5 fw-medium">Download</span>
																</p>
															</a>
														</div>
														<div class="col-md-2">
															<!-- Full Screen -->
															<div class="fullscreen-icon">
																<i class="fa-solid fa-expand fa-sm"></i>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- PDF Container -->
											<div class="d-flex justify-content-center" style="height: 50vh;">
												<iframe id="pdfViewer"
													src="<?php echo "user_data/$org_name/cor/" . $row['cor']; ?>"
													width="100%" height="100%" frameborder="0" class="cor"></iframe>
											</div>
										</div>
										<!-- SECOND COLUMN -->
										<div class="col-md-5 p-sm-5">
											<!-- Header -->
											<section>
												<div class="row">
													<div class="col-md-12 text-center">
														<!-- Title -->
														<p class="fw-bold fs-3 main-color spacing-4">Validate Account</p>
														</p>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12 d-flex justify-content-center">
														<!-- Divider -->
														<div class="text-center horizontal-line"></div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12 pt-sm-4">
														<!-- Description -->
														<p class="fw-medium fs-7 spacing-6">Please review the provided
															information before validating the account registration.</p>
													</div>
												</div>
											</section>

											<!-- Student Information -->
											<section>
												<div class="row pt-sm-4">
													<div class="col-md-12">
														<!-- Email -->
														<p class="fw-bold fs-6 main-color spacing-4">Email Address</p>
														<p class="fw-medium fs-6 pt-sm-2"><?php echo $row["email"] ?></p>
													</div>
												</div>

												<div class="row pt-sm-4">
													<div class="col-md-12">
														<!-- Status -->
														<p class="fw-bold fs-6 main-color spacing-4">Status</p>
														<p class="fw-medium fs-6 pt-sm-2"><?php echo $row["status"] ?></p>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12 pt-sm-4">
														<!-- Date -->
														<p class="fw-bold fs-6 main-color spacing-4">Date Registered</p>
														<p class="fw-medium fs-6 pt-sm-2">
															<?php echo date("F j, Y", strtotime($row["acc_created"])); ?>
														</p>
													</div>
												</div>
											</section>
											<!-- Buttons -->
											<section>
												<form id="validateAcc">
													<input type="hidden" id="voter_id" name="voter_id"
														value="<?php echo $voter_id; ?>">
													<div class="row pt-sm-5">
														<div class="col-md-6 text-end">
															<button
																class="btn btn-danger px-sm-5 py-sm-1-5 btn-sm fw-bold fs-6 spacing-6 btn-block"
																type="submit" id="reject" value="reject">Reject</button>
														</div>
														<div class="col-md-6 text-start">
															<button
																class="btn btn-success px-sm-5 py-sm-1-5 btn-sm fw-bold fs-6 spacing-6 btn-block"
																type="submit" id="approve" value="approve">Approve</button>
														</div>
													</div>
												</form>
											</section>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<?php include_once __DIR__ . '/includes/components/footer.php'; ?>

		<!-- Modal -->
		<div class="modal" id="approvalModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">

						<div class="d-flex justify-content-end">
							<i class="fa fa-solid fa-circle-xmark fa-xl close-mark light-gray"
							onclick="redirectToPage('voter-details.php?voter_id=<?php echo htmlspecialchars($row["voter_id"]); ?>')">
							</i>
						</div>
						<div class="text-center">
							<div class="col-md-12">
								<img src="images/resc/check-animation.gif" class="check-perc" alt="iVote Logo">
							</div>

							<div class="row">
								<div class="col-md-12 pb-3">
									<p class="fw-bold fs-3 success-color spacing-4">Account Approved!</p>
									<p class="fw-medium spacing-5">An email confirming the account approval has been sent.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<script src="../vendor/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<script src="scripts/script.js"></script>
		<script src="scripts/manage-voters.js"></script>
		<script src="scripts/feather.js"></script>


	</body>


	</html>

	<?php
} else {
	header("Location: landing-page.php");
}
?>