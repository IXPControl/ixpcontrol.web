<?php


$init = array();
$init['lockout'] = TRUE;
$init['sqlHost'] = "localhost";
$init['sqlUser'] = "";
$init['sqlPass'] = "";
$init['sqlDB'] = "";

function generateToken(){
	$token = bin2hex(openssl_random_pseudo_bytes(32));
	return $token;
}

function isValidEmail($email){ 
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function sConnect(){
    global $init;
    $ret = new mysqli($init['sqlHost'], $init['sqlUser'], $init['sqlPass'], $init['sqlDB']);
	if($ret->connect_error){
     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	}
   return $ret;
}


function getConfig(){
	global $connect;
			$getCFG = $connect->query("SELECT name,value FROM ix_config WHERE enabled = 'true'")->fetch_all();
			while ($row = array_shift($getCFG)) {
				$ret[array_shift($row)] = $row[0];
			}
			return $ret;
}

function dbQuery($method="SELECT", $table, $specifics="*", $query="", $return="ARRAY"){
	global $connect;
		if($method == "SELECT"){
			$get = mysqli_query($connect, "SELECT $specifics FROM $table $query");
		}
		if($method == "INSERT"){
			$get = mysqli_query($connect, "$method INTO $table $query");
		}
		if($method == "DELETE"){
			$get = mysqli_query($connect, "$method FROM $table $query");
		}
				if($return == "ARRAY"){
					$ret = $get->fetch_all(MYSQLI_ASSOC);
				}
		return $ret;
}

function cleanSQL($input){
      $output =  mysql_real_escape_string($input);   
    return $output;
 }

 function encodeString($input){
     $key = "#&sdfdfs789fs7d";
     $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $input, MCRYPT_MODE_CBC, md5(md5($key))));
     return $output;
 }

 function decodeString($input){
     $key = "#&sdfdfs789fs7d";
     $output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
     return $output;
 }

function cleanEntry($input){
    $output = strip_tags($input);
    $output = str_replace('&', '&amp;', $output);
    $output = str_replace('*', '', $output);
    $output = str_replace(',', '', $output);
    $output = str_replace('\'', '&apos;', $output);
    $output = str_replace('\"', ' Inch', $output);
    $output = str_replace('�', '', $output);
    $output = str_replace('�', '', $output);
	$output = str_replace('?', '', $output);
	$output = str_replace('!', '', $output);
	$output = str_replace('/', '', $output);
	$output = str_replace('(', '', $output);
	$output = str_replace(')', '', $output);
    return $output;
}


 function is_cli(){
        return (PHP_SAPI == 'cli' && empty($_SERVER['REMOTE_ADDR']));
    }
	
	/**
 * Debug function for printing the content of an object
 *
 * @param mixes $obj
 */
 function pr($obj){

    if (!is_cli())
        echo '<pre style="word-wrap: break-word">';
    if (is_object($obj))
        print_r($obj);
    elseif (is_array($obj))
        print_r($obj);
    else
        echo $obj;
    if (!is_cli())
        echo '</pre>';
}


function redirect($url){
    if (headers_sent()){
		echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }else{
      header('Location: ' . $url);
      die();
    }    
}


function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * Retrieve the OAuth access token and session handle
 * In my example I am just using the session, but in real world, this is should be a storage engine
 *
 */
 function retrieveSession(){
    if (isset($_SESSION['access_token'])) {
        $response['oauth_token']            =    $_SESSION['access_token'];
        $response['oauth_token_secret']     =    $_SESSION['oauth_token_secret'];
        $response['oauth_session_handle']   =    $_SESSION['session_handle'];
        return $response;
    } else {
        return false;
    }

}


/**
 * Persist the OAuth access token and session handle somewhere
 * In my example I am just using the session, but in real world, this is should be a storage engine
 *
 * @param array $params the response parameters as an array of key=value pairs
 */
 function persistSession($response){
    if (isset($response)) {
        $_SESSION['access_token']       = $response['oauth_token'];
        $_SESSION['oauth_token_secret'] = $response['oauth_token_secret'];
      	if(isset($response['oauth_session_handle']))  $_SESSION['session_handle']     = $response['oauth_session_handle'];
    } else {
        return false;
    }

}

function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

function flatten_array(array $array)
{
    return iterator_to_array(
         new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array)));
}

function array_flatten($array) {

   $return = array();
   foreach ($array as $key => $value) {
       if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
       else {$return[$key] = $value;}
   }
   return $return;

}

function peeringDB($endpoint, $arg="", $content, $return="json"){
	global $cfg;
	//peeringDB('net', '&asn=', '211954', 'json');
$url = "https://www.peeringdb.com/api/".$endpoint.$arg.$content;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

if($return == "json"){
	$ret = curl_exec($curl);	
}elseif($return == "array"){
	$ret = json_decode(curl_exec($curl), true);
	if(isset($ret['data'][0])){
		$ret = $ret['data'][0];
	}
}
curl_close($curl);
	return $ret;
}

function bgpView($endpoint, $content, $return="json"){
	global $cfg;
	//peeringDB('asn', '211954', 'json');
	$url = "https://api.bgpview.io/".$endpoint."/".$content."";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
if($return == "json"){
	$ret = curl_exec($curl);	
}elseif($return == "array"){
	$ret = json_decode(curl_exec($curl), true);
	if(isset($ret['data'])){
		$ret = $ret['data'];
	}
}
curl_close($curl);
	return $ret;
}

function zeroTier($ztNetwork, $ztAddress, $ztName="", $ztIP, $ztAPI, $return="json"){
	global $cfg;
	$url = "https://my.zerotier.com/api/network/".$ztNetwork."/member/".$ztAddress;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array("Authorization: Bearer ".$ztapi."", "Content-Type: application/json", );
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
	"id": "$ztID",
    "type": "Member",
    "networkId": "$ztNetwork",
    "nodeId": "$ztAddress",
    "name": "$ztName",
    "online": false,
    "description": "$ztName",
    "config": {
        "activeBridge": false,
        "address": "$ztAddress",
        "authorized": true,
        "capabilities": [],
        "id": "$ztAddress",
        "ipAssignments": ["$ztIP"],
        "noAutoAssignIps": false,
        "nwid": "$ztNetwork",
        "objtype": "member",
        "remoteTraceLevel": 0,
        "remoteTraceTarget": "          ",
        "revision": 9,
        "tags": [],
        "vMajor": 1,
        "vMinor": 6,
        "vRev": 2,
        "vProto": 12
    },
    "supportsRulesEngine": true
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

if($return == "json"){
	$ret = curl_exec($curl);	
}elseif($return == "array"){
	$ret = json_decode(curl_exec($curl), true);
}
curl_close($curl);
	return $ret;
}

function ixpcontrol_rs($rsNode, $rsAPI, $endpoint, $peerASN, $IPProto, $method="GET", $data="", $return="json"){
	//create, delete, status, restart, routes, bgpq4, edit
	global $cfg;
	$url = "http://".$rsNode.":9099/".$endpoint."/".$rsAPI."/".$IPProto."/".$peerASN;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
if($method == "POST"){
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
}else{
curl_setopt($curl, CURLOPT_POST, false);	
}
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
if($return == "json"){
	$ret = curl_exec($curl);	
}elseif($return == "array"){
	$ret = json_decode(curl_exec($curl), true);
}
curl_close($curl);
	return $ret;
}


function sparkpost($payload, $apiKey){
	$method = "POST";
	$uri = "transmissions";

	$headers = [ 'Authorization: '.$apiKey.'' ];
    $defaultHeaders = [ 'Content-Type: application/json' ];
    $curl = curl_init();
    $method = strtoupper($method);
    $finalHeaders = array_merge($defaultHeaders, $headers);
    $url = 'https://api.sparkpost.com:443/api/v1/'.$uri;
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if ($method !== 'GET') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $finalHeaders);
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result, true);
}


function telegram($botToken, $chatID, $chatContent, $return="json"){

  $website="https://api.telegram.org/bot".$botToken;
  $params=[
      'chat_id'=>$chatID, 
      'text'=>$chatContent,
  ];
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $ret = curl_exec($ch);
  curl_close($ch);
if($return == "json"){
	$ret = curl_exec($curl);	
}elseif($return == "array"){
	$ret = json_decode(curl_exec($curl), true);
}
curl_close($curl);
	return $ret;
}



?>