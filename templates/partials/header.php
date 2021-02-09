<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$cfg['siteName']?> :: <?=$cfg['siteTitle']?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/brands.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
			<div class="text-right">
			<div class="dropdown show">
			<?php if(!is_logged_in()){ ?>

<div class="dropdown">
<p><div class="btn-group" role="group" aria-label="Links">
<a href="<?=$cfg['siteURL']?>" class="btn btn-outline-info btn-round">Home</a>
  <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    User: XXXXXX
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/?act=uAccount">Account</a>
    <a class="dropdown-item" data-toggle="modal" data-target="#addASN">Add ASN</a>
	<div class="dropdown-divider"></div>
	<?php if(isset($cfg['peeringManager'])){ ?>
	<a class="dropdown-item" href="/?act=ixPeering">Peering Manager</a>
	<?php } ?>
	<a class="dropdown-item" href="/?act=ixSession">Sessions</a>
	<a class="dropdown-item" href="/?act=ixIRR">IRR Filter</a>
	<a class="dropdown-item" href="/?act=ixRouteServers">Route Servers</a>
	<?php if(isset($cfg['showStatistics'])){ ?>
	<div class="dropdown-divider"></div>
	<a class="dropdown-item" href="/?act=ixStatistics">IX Statistics</a>
	<a class="dropdown-item" href="/?act=ixUStatistics">My Statistics</a>
	<?php } ?>
	<div class="dropdown-divider"></div>
	<a class="dropdown-item" href="/?act=uSupport">Support</a>
	<div class="dropdown-divider"></div>
    <a class="dropdown-item" href="/?act=doLogout">Logout</a>
  </div>
</div>
</div>
			<?php } else { ?>
<div class="dropdown">
  <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Login/Signup
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" data-toggle="modal" data-target="#login">Login</a>
	<div class="dropdown-divider"></div>
    <a class="dropdown-item" data-toggle="modal" data-target="#register">Register</a>
  </div>
</div>
			<?php } ?>
			</div>
</div>