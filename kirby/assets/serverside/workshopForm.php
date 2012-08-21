<?php

require_once 'inc/MCAPI.class.php';
require_once 'inc/config.inc.php'; //contains apikey

$api = new MCAPI($apikey);
$listId = '799f4da2e1';
$retval = $api->lists();
$newInterest = $_POST['interest'];
$emailAddress = $_POST['email'];
echo("Interest: ".$newInterest.", Email:".$emailAddress);
//$newInterest = 'Web Intents with Paul Kinlan';
//$emailAddress = 'zenmaster13@hotmail.com';
if ($api->errorCode){
	echo "Unable to load lists()!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
} else {
	
echo($newInterest);
$userInfo = $api->listMemberInfo($listId, $emailAddress);

if($userInfo['success'] >= 1){
$userInfo['data'][0]['merges']['GROUPINGS'][0]['groups'].= ", ".$newInterest;
$mergeVars = $userInfo['data'][0]['merges'];
$api->listSubscribe($listId, $emailAddress,$mergeVars,'html',false,true,true,false);
}
if($userInfo['success'] == 0){
$api->listSubscribe($listId, $emailAddress,null,'html',false,true,true,false);
$userInfo = $api->listMemberInfo($listId, $emailAddress);
//echo(json_encode($userInfo));
$userInfo['data'][0]['merges']['GROUPINGS'][0]['groups'] = ", ".$newInterest;
$mergeVars = $userInfo['data'][0]['merges'];
$api->listSubscribe($listId, $emailAddress,$mergeVars,'html',false,true,true,false);
}
}

?>
