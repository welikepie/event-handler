<?php
/**
This Example shows how to Subscribe a New Member to a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'inc/MCAPI.class.php';
require_once 'inc/config.inc.php'; //contains apikey
//$email_address = $_GET['email'];
$api = new MCAPI($apikey);
//$aboutListId
$email = $_POST["EMAIL"];
$dev = false;
$soc = false;
$des = false;
$keyArray = array(
"DEV"=>false,
"DESIGN"=>false,
"SOCIAL"=>false
);

//printArray($_POST);
print_r($email);
     foreach ($_POST as $key => $value){
        print_r($key.":".$value);
		 if($key=="DEV"){
			$keyArray["DEV"]=$value;
		 }
		 if($key=="DESIGN"){
			 $keyArray["DESIGN"]=$value;
		 }
		 if($key=="SOCIAL"){
			 $keyArray["SOCIAL"]=$value;
		 }
    } 
print_r($keyArray);


// By default this sends a confirmation email - you will not see new members
// until the link contained in it is clicked!
 /*listSubscribe(string apikey, 
 string id, 
 string email_address, 
 array merge_vars, 
 string email_type, 
 bool double_optin, 
 bool update_existing, 
 bool replace_interests, 
 bool send_welcome) */
//$retval = $api->listSubscribe( $listId, $my_email, $merge_vars );
//$retval = $api->listSubscribe( $listId, $email_address, null,null,false,true,false,false );
$retval = $api->listSubscribe( $aboutListId, $email,$keyArray,null,false,true,false,false );

//print_r($retval);
if ($api->errorCode){
	$returnJSON = json_encode(array('response'=>"error","errorCode" =>$api->errorCode,"errorMessage"=>$api->errorMessage ));
} else {
	$returnJSON = json_encode(array('response'=>"success"));
}

if (isset($_GET['jsoncallback'])) {
	print $_GET['jsoncallback'] . '(' . ($returnJSON) . ')';
} else {
	print $returnJSON;
}
?>
