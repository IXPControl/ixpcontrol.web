 <?php

/***********************************
 * Initial Configs
 */
include('includes/config.php');
set_time_limit(0);
ini_set('memory_limit', '1024M');
if(isset($_GET['errors'])){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}else{
    error_reporting(0);
    ini_set('display_errors', '0');
}

function nvl(&$var, $default="") {
	return isset($var) ? $var : $default;
}

function evl(&$var, $default="") {
	return empty($var) ? $var : $default;
}

function ov(&$var) {
	return o(nvl($var));
}

function pv(&$var) {
	p(nvl($var));
}

function o($var) {
	return empty($var) ? "" : htmlSpecialChars(stripslashes($var));
}

function p($var) {
	echo o($var);
}

function verify_login($userEmail, $userPass) {
	global $connect;
	if (empty($userEmail) || empty($userPass)) return false;
		$qid = dbQuery("SELECT", 'ix_clients', '*', "WHERE userEmail = '$userEmail' AND userPassword = '$userPass'");	
	return $qid;
}

function is_logged_in() {
	global $_SESSION;
	return isset($_SESSION['user']['email'])
		&& !empty($_SESSION['user']['password'])
		&& nvl($_SESSION['user']["ip"]) == $_SERVER["REMOTE_ADDR"];
}

/*****************************
 * Pages and everything else.
 */
 

$connect = sConnect();
$cfg = getConfig();
switch (nvl($_REQUEST['act'])) {
	
	case 'doRegister': //View
		global $cfg, $connect;
			if(!isset($_POST['company'])){ $success = false; redirect("/?act=showError&eid=register1"); }
			if(!isset($_POST['password'])){ $success = false; redirect("/?act=showError&eid=register2"); }
			if(!isset($_POST['email'])){ $success = false; redirect("/?act=showError&eid=register3"); }
				if(strlen($_POST['company']) >= 60){ $success = false; redirect("/?act=showError&eid=register4"); }
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ $success = false; redirect("/?act=showError&eid=register5"); }
		
			$query = mysqli_query($connect, "SELECT * FROM ix_clients WHERE userEmail = '".$_POST['email']."'") or die(mysqli_error($connect));
				if(mysqli_num_rows($query) != 0){
					$success = false; 
					redirect("/?act=showError&eid=register6");
				}else{
					$userToken = generateToken();
			$sql = "INSERT INTO ix_clients (
										userCompany, userEmail, userPassword, userCode
											) VALUES (
										'".cleanEntry($_POST['company'])."', 
										'".$_POST['email']."', 
										'".md5(md5($_POST['password']))."', 
										'".$userToken."'
								)";
			$query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
				if($query){
					$getTemplate = mysqli_query($connect, "SELECT * FROM ix_emails WHERE emailCall = 'registrationVerify' LIMIT 1") or die(mysqli_error($connect));
					$d = $getTemplate->fetch_all(MYSQLI_ASSOC);
					$eTemplate = str_replace('{VERIFYCODE}', $userToken, $d['emailTemplate']);
					$eTemplate = str_replace('{VERIFYLINK}', $cfg['siteURL']."/?act=regVerify&eCode=".base64_encode(base64_encode($_POST['email']))."&verifyCode=".$userToken, $eTemplate);
					$eTemplate = str_replace('{WEBURL}', $cfg['siteURL'], $eTemplate);
					$eTemplate = str_replace('{WEBNAME}', $cfg['siteName'], $eTemplate);
					$eTemplate = str_replace('{LOGOURL}', $cfg['siteURL'].$cfg['logoURL'], $eTemplate);
					$payload = array("options" => array("sandbox" => ""),
									 "content" => array("from" => array(
																		"name" => $cfg['sparkPost_Name'],
																		"email" => $cfg['sparkPost_From']),
														"subject" => $d['emailSubject'], 
														"html" => $eTemplate,
														"reply_to" => $cfg['sparkPost_From']),
									"recipients" => array("0" => array(
																		"address" => $_POST['email'])
										));
					$sendEmail = sparkpost($payload, $cfg['sparkPost_key']);
					if($sendEmail){
							$eCode = base64_encode(base64_encode($_POST['email']));
						redirect("/?act=regVerify&eCode=$eCode");
					}else{
						redirect("/?act=showError&eid=register8");
					}
				}else{
					$success = false; 
					redirect("/?act=showError&eid=register9");
				}
			}
    break;
	case 'regVerify':
		global $cfg;
			include('templates/partials/header.php');
			include('templates/pages/registration.verify.php');
			include('templates/partials/footer.php');
    break;
	case 'doVerify': //View
		global $cfg, $connect;
			$query = mysqli_query($connect, "SELECT * FROM ix_clients WHERE userCode = '".cleanEntry($_REQUEST['eCode'])."' AND userVerified = 'false'") or die(mysqli_error($connect));
				if(mysqli_num_rows($query) == 0){
					$success = false; 
					redirect("/?act=showError&eid=register10");
				}else{
					$query = mysqli_query($connect, "UPDATE ix_clients SET userVerified = 'true' WHERE userCode = '".cleanEntry($_REQUEST['eCode'])."' AND userVerified = 'false'") or die(mysqli_error($connect));
					echo "Verified";
						redirect("/?act=Dashboard");
				}
    break;
	case 'doLogout':        //noView
		global $cfg, $_SESSION;
			session_start();
			session_unset();
			session_destroy();
				redirect($cfg['siteURL']);
			exit();
    break;
	case 'forgotPassword': //View
		global $cfg, $_SESSION;
			if(isset($_SESSION['user'])){
				redirect('/user/settings');
				die;
			}
			include('templates/partials/header.php');
			include('templates/pages/forgot.php');
			include('templates/partials/footer.php');
    break;
	case 'doForgot': //View
		global $cfg, $connect, $_SESSION;
		if(isset($_SESSION['user'])){
			redirect('/user/settings');
			die;
		}
		if(!isset($_POST['email'])){ $success = false; redirect("/?act=showError&eid=forgot1"); }
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ $success = false; redirect("/?act=showError&eid=forgot2"); }
		$a = mysqli_query($connect, "SELECT * FROM ix_clients WHERE userEmail = '".$_POST['email']."'");
		if(mysqli_num_rows($a) == 0){
			redirect("/?act=showError&eid=forgot3"); //Redirect No Account
		}else{
			if(mysqli_num_rows($a) > 1){
				redirect("/?act=showError&eid=forgot4"); //Redirect More than one!
			}else{
				$b = $a->fetch_all(MYSQLI_ASSOC);
				if($b['userVerified'] == "true"){
					$genToken = generateToken();
					mysqli_query($connect, "UPDATE ix_clients SET userCode = '".$genToken."' WHERE userEmail = '".$_POST['email']."'");
					$getTemplate = mysqli_query($connect, "SELECT * FROM ix_emails WHERE emailCall = 'forgotPassword' LIMIT 1") or die(mysqli_error($connect));
					$d = $getTemplate->fetch_all(MYSQLI_ASSOC);
					$eTemplate = str_replace('{VERIFYCODE}', $genToken, $d['emailTemplate']);
					$eTemplate = str_replace('{VERIFYLINK}', $cfg['siteURL']."/?act=regVerify&eCode=".base64_encode(base64_encode($_POST['email']))."&verifyCode=".$genToken, $eTemplate);
					$eTemplate = str_replace('{WEBURL}', $cfg['siteURL'], $eTemplate);
					$eTemplate = str_replace('{WEBNAME}', $cfg['siteName'], $eTemplate);
					$eTemplate = str_replace('{LOGOURL}', $cfg['siteURL'].$cfg['logoURL'], $eTemplate);
					$payload = array("options" => array("sandbox" => ""),
									 "content" => array("from" => array(
																		"name" => $cfg['sparkPost_Name'],
																		"email" => $cfg['sparkPost_From']),
														"subject" => $d['emailSubject'], 
														"html" => $eTemplate,
														"reply_to" => $cfg['sparkPost_From']),
									"recipients" => array("0" => array(
																		"address" => $_POST['email'])
										));
					$sendEmail = sparkpost($payload, $cfg['sparkPost_key']);
					if($sendEmail){
							$eCode = base64_encode(base64_encode($_POST['email']));
						redirect("/?act=regVerify&eCode=$eCode");
					}else{
						redirect("/?act=showError&eid=forgot5");
					}
					
					header("HTTP/1.1 303 See Other");
					header("Location: https://".$_SERVER['HTTP_HOST']."/user.php?act=login&status=NewPassword"); 
				}
			}
		}
    break;
	case 'setPassword': //View
		global $cfg, $_SESSION;
			if(isset($_SESSION['user'])){
				redirect('/user/settings');
				die;
			}
			include('templates/partials/header.php');
			include('templates/pages/newPassword.php');
			include('templates/partials/footer.php');
    break;
	case 'doSetPassword': //View
		global $cfg, $_SESSION;
			if(isset($_SESSION['user'])){
				redirect('/user/settings');
				die;
			}
			$payload = [ "options" => [ "sandbox" => false,], 'content' => [ 'from' => [ 'name' => $cfg->siteName, 'email' => $cfg->smtpFrom, ],'subject' => $d->emailSubject, 'html' => $eTemplate, 'reply_to' => $cfg->smtpFrom ], 'recipients' => [ [ 'address' => $_POST['email'], ], ],];	
			$sendEmail = sparkpost($payload);
			header("Location: /?act=login"); 
    break;
	case 'doLogin':        //noView
		global $cfg, $connect, $_SESSION;
			if(empty($_POST['email'])){
				$success = false; 
				redirect("/?act=showError&eid=login1");
			}elseif(empty($_POST['password'])){
				$success = false; 
				redirect("/?act=showError&eid=login2");
			}elseif(strlen($_POST['password']) < 6){
				$success = false; 
				redirect("/?act=showError&eid=login3");
			}
			$a = mysqli_query($connect, "SELECT * FROM ix_clients WHERE userEmail = '".cleanEntry($_POST['email'])."' AND userPassword = '".md5(md5($_POST['password']))."' LIMIT 1");
			if(mysqli_num_rows($a) == 0){
				$success = false; 
				redirect("/?act=showError&eid=login4");
				die;
			}elseif(mysqli_num_rows($a) > 1){
				$success = false; 
				redirect("/?act=showError&eid=login5");
				die;
			}else{
				$b = $a->fetch_array();
				if($b['userEnabled'] == 'false'){
				$success = false; 
				redirect("/?act=showError&eid=login6");
				die;
			}
			
			
			$user = verify_login($_POST["email"], md5(md5($_POST['password'])));
				if ($user) {
if (ini_get('session.use_cookies'))
{
    $p = session_set_cookie_params(0, '/', 'oceanixp.oceanix.net.au', 0, 1);;
    setcookie(session_name(), '', time() - 31536000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
//					session_start(['cookie_lifetime' => time()+31556926,]);
					$_SESSION['user']['email'] = $b['userEmail'];
					$_SESSION['user']['id'] = $b['uid'];
					$_SESSION['user']['password'] = md5(md5(md5($_POST['password'])));
					$_SESSION['user']['sessionid'] = strtoupper(md5($b['userEmail'].$b['uid'])."-".time());
					$_SESSION['user']["ip"] = $_SERVER["REMOTE_ADDR"];	
				redirect("/?act=Dashboard");
			}else{
				$success = false; 
				//redirect("/?act=showError&eid=login7");
			}
		}
    break;
	case 'showError': //View
	global $cfg;
		$pageTitle = "ERROR";
		$eArray = array(
						"register1" => "",
						"register2" => "",
						"register3" => "",
						"register4" => "",
						"register5" => "",
						"register6" => "Error: Existing Account Found, If you already have a user account, please use forgot password function to gain access.",
						"register7" => "",
						"register8" => "",
						"register9" => "",
						"login1" => "Error: Invalid Email Address Specified",
						"login2" => "Error: Invalid Password Specified",
						"login3" => "Error: Password is too short, Are you sure that it is correct?",
						"login4" => "Error: No account found.",
						"login5" => "Error: Multiple Accounts Detected, Contact Support.",
						"login6" => "Error: User Account Disabled, Contact Support.",
						"login7" => "Error: Unable to Verify Account Details. Please try again.",
						"newConn1" => "",
						"newConn2" => "",
						"newConn3" => "",
						"newConn4" => "",
						"newConn5" => "",
						"newConn6" => "",
						"newConn7" => "",
						"newConn8" => "",
						"newConn9" => "",
						"newConn10" => "",
						"newConn11" => "",
						"newConn12" => "",
						"newConn13" => ""
						);
			include('templates/partials/header.php');
			include('templates/pages/error.view.php');
			include('templates/partials/footer.php');
    break;

	case 'newZeroTier': //View
	global $cfg, $_SESSION;
	$pageTitle = "ZeroTier Connection Created";
		include('templates/partials/header.php');
		include('templates/pages/details/zerotier.new.php');
		include('templates/partials/footer.php');
    break;
		
	case 'userVerify': //View
	global $cfg;
	
    break;
	
	case 'newConnection': //View
	global $cfg, $_SESSION;
		if(!isset($_POST['company'])){ $success = false; redirect("/?act=showError&eid=newConn1"); }
		if(!isset($_POST['email'])){ $success = false; redirect("/?act=showError&eid=newConn1"); }
		if(!isset($_POST['asn'])){ $success = false; redirect("/?act=showError&eid=newConn1"); }
		if(!isset($_POST['ocix-location'])){ $success = false; redirect("/?act=showError&eid=newConn1"); }
		if(!isset($_POST['conntype'])){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(strlen($_POST['company']) >= 40){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(!substr($_POST['asn'], 0, 2 ) === "AS"){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(strlen($_POST['asn']) >= "12"){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(!substr($_POST['ocix-location'], 0, 5 ) === "OCIX-"){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(strlen($_POST['ocix-location']) > 9){ $success = false; redirect("/?act=showError&eid=newConn1"); }
			if(!in_array($_POST['conntype'], array('Local', 'ZeroTier'))){$success = false; redirect("/?act=showError&eid=newConn1"); }
			
				$pdb = peeringDB('net', '&asn=', $_POST['asn'], 'array');
					if(isset($pdb['data']['0']['irr_as_set']) && !empty($pdb['data']['0']['irr_as_set'])){
						$_POST['asset'] = $pdb['data']['0']['irr_as_set'];
					}else{
						$_POST['asset'] = false;
					}
					if(!empty($pdb['data']['0']['policy_general'])){
						$_POST['peering'] = ucwords($pdb['data']['0']['policy_general']);
					}else{
						$_POST['peering'] = "OPEN";
					}
			
		if($_POST['conntype'] == "ZeroTier" && !empty($_POST['ztAddress'])){
			 $ips = "./ix/".$_POST['ocix-location']."/ips/";
				$filecount = 0;
				$files = glob($ips . "*");
			if ($files){
				$userIP = (count($files) + 1);
			}
			if (!preg_match("/^[a-z0-9]*$/", $_POST['ztAddress'])) {
				$success = false; 
				redirect("/?act=showError&eid=newConn1");
			}
			if(!strlen($_POST['ztAddress']) == 10){
				$success = false; 
				redirect("/?act=showError&eid=newConn1"); 
			}
			$ixloc = $_POST['ocix-location'];
			$zta = $_POST["ztAddress"];
			$ztNetwork = $IXNode[$ixloc]["ZTNetwork"];
			$ztAPI = $IXNode[$ixloc]["ZTAPI"];
			$ztIP = $IXNode[$ixloc]["IPSub"].$userIP;
			$ztName = $_POST["company"]." - ". $_POST["asn"];
			$ztID = $ztNetwork."-".$zta;
			
			$ztDecode = zeroTier($ztNetwork, $zta, $ztName, $ztIP, $ztAPI, 'json');
			
			if($rDecode['id'] == $ztID){
				if($files){
					$file_name = $directory.$userIP; 
					$file = fopen($file_name, 'w') or die(redirect("/?act=showError&eid=newConn1"));  
					fclose($file); 
				$ocixDump = json_encode(array(
												"companyName" => $_POST['company'],
												"ASN" => $_POST['asn'],
												"AS-SET" => $_POST['asset'],
												"PEERIP" => array("IPv4" => "", "IPv6" => ""),
												"IXIP" => array("IPv4" => "", "IPv6" => $ztIP),
												"IXPeering" => "OPEN",
												"IXSpeed" => "100 MB/s",
												"Connection" => $_POST['conntype'],
												"ContactEmail" => $_POST['email'],
												"ConnectionInfo" => array("ZeroTierID" => $zta, "VXLANID" => "", "GRETAPID" => "", "WireGuardID" => "", "OpenVPNID" => "", ),
												"Joined" => time(),
											));
					$fp = fopen("./ix/".$ixloc."/members.dat", 'a');
					fwrite($fp, "\n".$ocixDump);
				}
					include("templates/pages/newzt.php");
				}else{
					$success = false; 
					redirect("/?act=showError&eid=newConn1");
				}
		}
    break;
	

	
	case 'createIXP': //View
	global $cfg;
	
    break;

	
	case 'newIXP': //View
	global $cfg;
		include('templates/partials/header.php');
		include('templates/pages/create.php');
		include('templates/partials/footer.php');
    break;
	
	
	case 'blog': //View
	global $cfg;
	
    break;
	
	case 'blogView': //View
	global $cfg;
	
    break;
	


	
	

		
		

	

	
	
	
	
	case 'uAccount': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/account.edit.php');
		include('templates/partials/footer.php');
    break;
	
	case 'doAccount': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	
	case 'doAddASN': //View
	global $cfg, $connect, $_SESSION;
		print_r($_REQUEST);
		
		$a = peeringDB('net', '?asn=', $_POST['asnumber'], 'array');
			
		$b = bgpView('asn', $_POST['asnumber'], 'array');
			
			print_r($a);
			echo "<br /><br />";
			print_r($b);
    break;
	
	case 'doRemoveASN': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	
	case 'ixPeering': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/peering.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'ixSession': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/session.view.php');
		include('templates/partials/footer.php');
    break;
	case 'do-ixSession': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	case 'ixIRR': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/irr.view.php');
		include('templates/partials/footer.php');
    break;
	case 'do-ixIRR': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	case 'ixRouteServers': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/routeserver.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'ixStatistics': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/statistics.ix.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'ixUStatistics': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/statistics.user.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'uSupport': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/support.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'supportView': //View
	global $cfg, $connect, $_SESSION;
		include('templates/partials/header.php');
		include('templates/pages/users/ticket.view.php');
		include('templates/partials/footer.php');
    break;
	
	case 'doNewTicket': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	
	case 'doTicketReply': //View
	global $cfg, $connect, $_SESSION;
		
    break;
	
	
	
	default: //View
	global $cfg, $_SESSION;
			$pageTitle = "Index";		
		include('templates/partials/header.php');
		include('templates/pages/index.php');
		include('templates/partials/footer.php');
    break;
}