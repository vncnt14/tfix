
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="tfixlogin.css">
	<title>TFIX</title>
</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Poppins', sans-serif;
}

:root {
	--grey: #F4F2FF;
	--dark-grey: #B7B7B7;

	--green: #23AE00;
	--light-green: #BDFFAC;

	--red: #FE2727;
	--light-red: #FFD2D2;

	--blue: #277FFE;
	--light-blue: #B6C6FF;
	--dark-blue: #1368E3;

	--bs: #AECFFF;
	--text: #9B9B9B;
}

a {
	color: var(--blue);
	transition: .3s ease;
	text-decoration: none;
}

a:hover {
	color: var(--dark-blue);

}

body {
	background-color: #1368E3;
	background-image: linear-gradient(rgba(4,9,50,0.6),rgba(4,9,50,0.6)),url(tfixbg2.jpg);
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	padding: 0 16px;
	background-position: fill;
  	background-size: cover;
}

.container {
	max-width: 500px;
	width: 100%;
	position: relative;
	margin-bottom: -10%
}
form {
	width: 100%;
	padding: 28px;
	border-radius: 12px;
	background: #fff;
	position: absolute;
	top: 50%;
	transform: translateY(-50%) scale(.8);
	opacity: 0;
	z-index: 100;
	transition: all .3s ease;
	transition-delay: 0s;
}
form.active {
	transform: translateY(-50%);
	opacity: 1;
	z-index: 200;
	transition-delay: .3s;
}
.title {
	font-size: 24px;
	font-weight: 600;
	margin-bottom: 20px;
}
.form-group {
	margin-bottom: 14px;
}
.form-group label {
	display: inline-block;
	margin-bottom: 4px;
}
.input-group {
	width: 100%;
	position: relative;
}
.input-group input {
	padding: 12px 40px 12px 20px;
	outline: none;
	border-radius: 6px;
	border: 1px solid var(--dark-grey);
	width: 100%;
	transition: all .3s ease;
}

/* Validation */
.input-group input:focus,
.input-group input:not(:placeholder-shown) {
	border-color: var(--blue);
	background: var(--grey);
}
.input-group input:focus + i,
.input-group input:not(:placeholder-shown) + i {
	color: var(--blue);
}
.input-group input:focus:valid {
	box-shadow: 0 0 0 4px var(--light-green);
}
.input-group input:valid:not(:placeholder-shown) {
	border-color: var(--green);
}
.input-group input:valid:not(:placeholder-shown) + i {
	color: var(--green);
}
.input-group input:invalid:not(:placeholder-shown) {
	border-color: var(--red);
}
.input-group input:invalid:not(:placeholder-shown) + i {
	color: var(--red);
}
.input-group input:focus:invalid {
	box-shadow: 0 0 0 4px var(--light-red);
}
.input-group input:focus,
.input-group input:focus:placeholder-shown {
	box-shadow: 0 0 0 4px var(--bs);
}
/* Validation */

.input-group i {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	right: 20px;
	color: var(--text);
	pointer-events: none;
	transition: all .3s ease;
}
.form-group .help-text {
	font-size: 12px;
	color: var(--text);
}
.btn-submit {
	padding: 12px 0;
	display: block;
	width: 100%;
	color: #fff;
	border-radius: 6px;
	cursor: pointer;
	transition: all .3s ease;
	border: none;
	font-weight: 500;
	background: var(--blue);
	margin-bottom: 20px;
}
.btn-submit:hover {
	background: var(--dark-blue);
}

.btn-request-service {
            background-color: #fff;
            color: var(--blue);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

</style>
		<header>
            <div class="nav-bar">
            <img src="logo.png" class="logo-icon">
            <a href="#" class="logo">Tfix</a>
            <div class="navigation">
              <div class="nav-items">
          <i class="uil uil-times nav-close-btn"></i>
          <a class="btn" href="#"><i class="uil uil-home"></i>OUR SERVICES</a>
          <a class="btn" href=""><i class="uil uil-compass"></i>ABOUT US</a>
		  <a class="btn" href="tfixlogin.php"><i class="uil uil-compass"></i>LOG IN</a>
		  <a class="btn" href="tfixcreate.php"><i class="uil uil-compass"></i>SIGN UP</a>
		  	<!--<div class="dropdown">
				<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				LOG IN AS
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-dark" href="tfixlogin.php">User</a>
					<a class="dropdown-item text-dark" href="tfixpersonnel_login.php">Personnel</a>
					<a class="dropdown-item text-dark" href="tfixrepairman_login.php">Repairman</a>
					<a class="dropdown-item text-dark" href="tfixshopowner_login.php">Shop Owner</a>
				</div>
   			</div>-->
			<!--<div class="dropdown">
				<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				SiGN UP AS
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item text-dark" href="tfixcreate.php">User</a>
					<a class="dropdown-item text-dark" href="tfixpersonnel_create.php">Personnel</a>
					<a class="dropdown-item text-dark" href="tfixrepairman_create.php">Repairman</a>
					<a class="dropdown-item text-dark" href="tfixshopowner_create.php">Shop Owner</a>
				</div>
   			</div>-->
          </div>
          </div>
          <a href="#" class="btn-request-service">Request Service Now</a>
            </div>
        </header>
	
	<div class="container">
		<form action="login.php" method="POST" class="login active">
            <h2 class="title">Login with your account</h2>



			
            <div class="form-group">
              <label for="username">Username</label>
              <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Enter your username">
                <i class='bx bx-user'></i>
              </div>
            </div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<input type="password" id="password" name="password"  placeholder="Your password">
					<i class='bx bx-lock-alt' ></i>
				</div>
			</div>
            
			<center><button class="btn-submit">Login</button></center>

			<a href="#">Forgot password?</a>
			<p>I don't have an account. <a href="tfixcreate.php">Register</a></p>
		</form>

        
	</div>

	<script>
        function switchForm(className, e) {
	e.preventDefault();
	const allForm = document.querySelectorAll('form');
	const form = document.querySelector(`form.${className}`);

	allForm.forEach(item=> {
		item.classList.remove('active');
	})
	form.classList.add('active');
}


	const registerPassword = document.querySelector('form.register #password');
	const registerConfirmPassword = document.querySelector('form.register #confirm-pass');

	registerPassword.addEventListener('input', function () {
		registerConfirmPassword.pattern = `${this.value}`;
	})
		</script>

	<script>
		function redirectUser(selectedValue) {
			if (selectedValue === 'Repairman') {
				window.location.href = 'tfixrepairman_create.php';
			}
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>