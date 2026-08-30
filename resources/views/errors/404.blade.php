<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="404 Page Not Found">
	<meta name="robots" content="noindex, nofollow">
	<title>404 - Page Not Found</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/bootstrap.min.css">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Main CSS -->
	<style>
		body {
			background: linear-gradient(135deg, #f9f9f9, #f1f1f1);
			min-height: 100vh;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: flex-start;
			margin: 0;
			padding: 20px;
		}
		.logo {
			max-width: 220px;
			height: auto;
			margin-bottom: 40px;
		}
		.error-img {
			max-width: 450px;
			width: 100%;
			height: auto;
			margin: 0 auto 30px auto;
			display: block;
		}
		.content {
			text-align: center;
			max-width: 600px;
			width: 100%;
		}
		.content h1 {
			font-size: 32px;
			font-weight: 600;
			margin-bottom: 15px;
		}
		.content p {
			font-size: 16px;
			color: #666;
			margin-bottom: 25px;
		}
		.content .btn {
			padding: 10px 20px;
			font-size: 16px;
		}

		/* Responsive fixes */
		@media (max-width: 768px) {
			.logo {
				max-width: 180px;
				margin-bottom: 30px;
			}
			.error-img {
				max-width: 320px;
			}
			.content h1 {
				font-size: 26px;
			}
			.content p {
				font-size: 14px;
			}
		}
		@media (max-width: 480px) {
			.logo {
				max-width: 150px;
				margin-bottom: 20px;
			}
			.error-img {
				max-width: 240px;
			}
		}
	</style>
</head>

<body>
	<!-- Logo Top -->
	<img src="assets/img/logo.svg" alt="logo" class="logo">

	<!-- Error Image Center -->
	<img src="assets/img/bg/error-404.svg" alt="404 Error" class="error-img">

	<!-- Content -->
	<div class="content">
		<h1>Oops, something went wrong</h1>
		<p>Error 404: Page not found.<br> Sorry, the page you are looking for doesn’t exist or has been moved.</p>
		<a href="{{ route('Home') }}" class="btn btn-primary d-inline-flex align-items-center">
			<i class="ti ti-arrow-left me-2"></i> Back to Dashboard
		</a>
	</div>
</body>
</html>
