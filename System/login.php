<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - RealBiz ERP V9.1</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<style>
        body {
            background-color: #0b4bb4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .blue-section {
            background-color: #2196F3;
            color: #000000;
            position: relative;
            height: 100%;
            padding: 40px;
        }

        .blue-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .blue-section p {
            opacity: 0.8;
            max-width: 400px;
        }

        .form-section {
            padding: 40px;
            background: white;
            border-radius: 0 20px 20px 0;
        }

        .form-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            background-color: #f5f5f5;
            border: none;
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background-color: #0a4bb3;
            border: none;
            font-weight: 600;
        }

        .btn-outline-secondary {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: white;
            color: #333;
            font-weight: 600;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #777;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 10px;
        }

        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .circle-1 {
            width: 150px;
            height: 150px;
            bottom: 50px;
            left: 50px;
        }

        .circle-2 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            right: -30px;
        }

        .form-check-label {
            color: #777;
            font-size: 0.9rem;
        }

        .forgot-password {
            font-size: 0.9rem;
            color: #0d6efd;
            text-decoration: none;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }

        .signup-link a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        .input-group-text {
            background-color: #f5f5f5;
            border: none;
            border-right: none;
            height: 48px;
        }

        .password-toggle {
            background-color: #f5f5f5;
            border: none;
            color: #0d6efd;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
        }

        @media (max-width: 767.98px) {
            .login-container {
                flex-direction: column;
            }
            .blue-section {
                border-radius: 20px 20px 0 0;
                padding: 30px;
            }
            .form-section {
                border-radius: 0 0 20px 20px;
            }
        }
	</style>
</head>
<body>
<div class="login-container">
	<div class="row g-0">
		<!-- Left Blue Section -->
		<div class="col-md-5">
			<div class="blue-section">
				<h1>WELCOME</h1>
				<h5 class="mb-4">A Complete ERP Solution For your Business</h5>
				<p>Manage your entire real estate operation with ease—whether you're handling property listings, customer leads, payments, or project development. Our all-in-one Real Estate ERP solution streamlines your workflow, boosts productivity, and keeps your business organized and scalable. From lead generation to final handover, everything is managed in one smart platform designed for real estate professionals.</p>

				<!-- Decorative circles -->
				<div class="circle circle-1"></div>
				<div class="circle circle-2"></div>
			</div>
		</div>

		<!-- Right Form Section -->
		<div class="col-md-7">
			<div class="form-section">
				<h2>Sign in</h2>
				<p class="text-muted mb-4">Please Provide your login info below</p>

				<form action="./index.php?Theme=default&Base=System&Script=loginaction" method="post">
					<!-- Username Field -->
					<div class="input-group mb-3">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                            </span>
						<input type="text" name="LogInUserName" class="form-control" placeholder="User Name">
					</div>

					<!-- Password Field -->
					<div class="input-group mb-3">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                </svg>
                            </span>
						<input type="password" class="form-control" name="LogInUserPassword" id="password" placeholder="Password">
						<span class="input-group-text password-toggle" onclick="togglePassword()">SHOW</span>
					</div>

					<!-- Remember Me and Forgot Password -->
<!--					<div class="d-flex justify-content-between mb-4">-->
<!--						<div class="form-check">-->
<!--							<input class="form-check-input" type="checkbox" id="remember">-->
<!--							<label class="form-check-label" for="remember">Remember me</label>-->
<!--						</div>-->
<!--						<a href="#" class="forgot-password">Forgot Password?</a>-->
<!--					</div>-->

					<!-- Sign In Button -->
					<button type="submit" class="btn btn-primary mb-3">Sign in</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Password Toggle Script -->
<script>
	function togglePassword() {
		const passwordField = document.getElementById('password');
		const toggleButton = document.querySelector('.password-toggle');

		if (passwordField.type === 'password') {
			passwordField.type = 'text';
			toggleButton.textContent = 'HIDE';
		} else {
			passwordField.type = 'password';
			toggleButton.textContent = 'SHOW';
		}
	}
</script>
</body>
</html>