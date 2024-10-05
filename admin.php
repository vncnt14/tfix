<?php
session_start();

if (!isset($_SESSION['is_admin'])) {
	header("Location: index.php");
	exit;
}
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Admin Tfix</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="stylesheet.css">
</head>

<body>

	<div class="container" style="padding-left: 0px;">
		<!-- Side Menu -->
		<div class="navigation ">
			<ul>
				<li>
					<a href="#" class="sticky-top" style="border-bottom:1px solid;">
						<span class="icon"><img src="images/AdminLTELogo.png" class="logo"></span>
						<span class="title">
							<h5 class="headding" style=" padding: 16px; font-size:18px; margin-top: 8px;">Tfix</h5>
						</span>
					</a>
				</li>
				<li>
					<a href="#" class="border-bottom" style="margin: 6px 0 8px 0;">
						<span class="icon">
							<div class="profile" onclick=" menuToggle();"><img src="images/avatar.jpg" class="sideimg">
							</div>
						</span>
						<span class="title">
							<h2 class="headding" style="margin-top: 5px; margin-left: 5px;"> <?php echo $_SESSION['firstname']; ?> <?php echo $_SESSION['lastname']; ?></h2>
						</span>
					</a>
				</li>
				<li>

				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
						<span class="title">
							<h2 class="headding" style="margin-top: 5px;">Dashboard</h2>
						</span>
					</a>
				</li>
				<li>
					<a href="user.php">
						<span class="icon"><i class="fa fa-th" aria-hidden="true"></i></span>
						<span class="title">
							<h2 class="headding" style="margin-top: 5px;">Manage user</h2>
						</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fa fa-pie-chart" aria-hidden="true"></i></span>
						<span class="title">
							<h2 class="headding" style="margin-top: 6px;">TFix Process</h2>
						</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
						<span class="title">
							<h2 class="headding" style="margin-top: 2px;">Forms</h2>
						</span>
					</a>
				</li>
				<li>
					<a href="logout.php">
						<span class="icon"><i class="bx bxs-log-out-circle" aria-hidden="true"></i></span>
						<span class="title">
							<h2 class="headding" style="margin-top: 2px;">Log-out</h2>
						</span>
					</a>
				</li>
			</ul>
		</div>
		<!--end side nav-->
		<!--main menu-->
		<div class="main " style="z-index: 1;">
			<div class="topbar sticky-top" style="z-index: 2; ">
				<div class="left" style="display: flex; flex-direction: row; margin: 0 0 0 0;">
					<div class="toggle " onClick="toggleMenu();"></div>
					<div class="home " style="padding-right: 0px; color: black;">Home </div>
					<div class="home" style="padding-right: 0px;">Contact</div>
					<div class="right1 navbar-right " style="display: flex; flex-direction: row; float: right;">
						<ul class="nav navbar-nav ml-auto" style="display: flex;flex-direction: row;">
							<li class="nav-item">
								<a class="nav-link">
									<i id="hovnav3" class="fa fa-search" aria-hidden="true" style="color: grey;"></i>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link">
									<div class="dropdown" id="dropdown">
										<button type="button" class="btn" data-toggle="dropdown" style="margin: -35px 0 0 0; padding: 0 0 0 0; color: grey;">
											<i class="fa fa-comments" aria-hidden="true"></i>
											<span class="badge" style="position: absolute;top: -10px;right: -3px;padding: 1px 4px; border-radius: 50%; background-color: red;color: white;">3</span>
										</button>
										<div class="dropdown-menu" id="dropdown-menu" style="    margin: -22px 0 0 -196px;">
											<a class="dropdown-item" href="#">
												<div class="flex-container border-bottom" style="display: flex; flex-direction: row;">
													<div class="chat" style="flex-grow: 1;"><img src="images/avatar.jpg"></div>
													<div class="flex-container" style="display: flex; flex-direction: column; flex-grow: 2">
														<div style="margin-left: 40px; font-size: 18px;">Daniel Matsunaga
														</div>
														<div style="margin-left: 40px; font-size: 12px;">Ma'am naa mo alaga mog Iring looy manggud kaayo?</div>
														<div class="time"><i class="fa fa-clock-o" aria-hidden="true"></i> 4 Hours Ago</div>
													</div>
												</div>
											</a>
											<a class="dropdown-item" href="#">
												<div class="flex-container border-bottom" style="display: flex; flex-direction: row;">
													<div class="chat" style="flex-grow: 1;"><img src="images/user2-160x160.jpg"></div>
													<div class="flex-container" style="display: flex; flex-direction: column; flex-grow: 2">
														<div style="margin-left: 40px; font-size: 18px;">Ann Cortiz
														</div>
														<div style="margin-left: 40px; font-size: 12px;">Salamat sa Serbisyo dakong tabang ni siya na App</div>
														<div class="time"><i class="fa fa-clock-o" aria-hidden="true"></i> 4 Hours Ago</div>
													</div>
												</div>
											</a>
											<a class="dropdown-item" href="#">
												<div class="flex-container border-bottom" style="display: flex; flex-direction: row;">
													<div class="chat" style="flex-grow: 1;"><img src="images/avatar.jpg"></div>
													<div class="flex-container" style="display: flex; flex-direction: column; flex-grow: 2">
														<div style="margin-left: 40px; font-size: 18px;">Maja Salvador
														</div>
														<div style="margin-left: 40px; font-size: 12px;">Hi pa order ku ug pagkaon sa Iring Thank you</div>
														<div class="time"><i class="fa fa-clock-o" aria-hidden="true"></i> 4 Hours Ago</div>
													</div>
												</div>
											</a>
										</div>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link">
									<div class="dropdown border-bottom" id="dropdown1">
										<button type="button" class="btn" data-toggle="dropdown" style="margin: -35px 0 0 0; padding: 0 0 0 0; color: grey;">
											<i id="hovnav" class="fa fa-bell" aria-hidden="true" style="color: grey;"></i>
											<span class="badge" style="position: absolute;top: -10px;right: -3px;padding: 1px 4px; border-radius: 50%; background-color: yellow;color: black;">3</span>
										</button>
										<div class="dropdown-menu" id="dropdown-menu1" style="   margin: -22px 0 0 -196px;">
											<a class="dropdown-item" href="#">
												<div class="flex-container" style="color: grey; font-size: 14px; align-items: center; margin-left: 40px; padding: 10px;">
													15 Notifications
												</div>
											</a>
											<a class="dropdown-item" href="#">
												<div class="flex-container border-top" style="display: flex; flex-direction: row; ">
													<div><i class="fa fa-envelope" aria-hidden="true" style="font-size: 12px;padding: 10px;"></i> 4 New Messages
													</div>
													<div style="float: right; margin-left: 40px; color: gray; font-size: 12px; margin-top: 10px;">
														3 min</div>
												</div>
											</a>
											<a class="dropdown-item" href="#">
												<div class="flex-container border-top" style="display: flex; flex-direction: row; ">
													<div><i class="fa fa-users" aria-hidden="true" style="font-size: 12px;padding: 10px; "></i> 8 Friend
														Requests</div>
													<div style="float: right; margin-left: 40px; color: gray; font-size: 12px; margin-top: 10px;">
														2 min</div>
												</div>
											</a>
											<a class="dropdown-item" href="#">
												<div class="flex-container" style="color: grey; font-size: 12px; align-items: center; margin-left: 40px; padding: 10px;">
													See All

												</div>
											</a>
										</div>
									</div>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"><i id="hovnav1" class="fa fa-arrows-alt" aria-hidden="true" style="color: grey;"></i></a>

							</li>
							<li class="nav-item">
								<a class="nav-link"><i id="hovnav2" class="fa fa-th-large" aria-hidden="true" style="color: grey;"></i></a>

							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- sales -->

</html>
<!-- toggle menu -->
<script type="text/javascript">
	function toggleMenu() {
		let toggle = document.querySelector('.toggle');
		let navigation = document.querySelector('.navigation');
		let main = document.querySelector('.main');
		toggle.classList.toggle('active');
		navigation.classList.toggle('active');
		main.classList.toggle('active');
	}
</script>
</body>

</html>