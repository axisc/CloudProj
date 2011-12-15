<?php
  
  // Include the Class Definition
  require_once('oauth_en.php');
  
/*
*
* @abstract:  Test LinkedIn's Php Class
* @author: Christophe Fiat
* @copyright: FormatiX.EU
*
*/

// Set Parameters
$params = Array(    'consumerKey' => 'YOUR_CONSUMER_KEY',
'consumerSecret' => 'YOUR_CONSUMER_SECRET_KEY',
'localUrl' => 'YOUR_Local_URL',
'callbackUrl' => 'YOUR_Callback_URL',
'zendPath'	 => 'YOUR_Zend_Path',	
'zendIncubatorPath'	 => 'YOUR_Zend_Incubator_Path'						
);		

// Create an Instance of LinkedIn's PHP Class		
$linkedin = new linkedIn($params);

// Connect to LinkedIn API Via OAuth
$linkedin->connect();

// Call whoAmI method to Get User's profile
$profilInfo =$linkedin->whoAmI();

// Display User's profile
echo'<h2>First Name: '.$profilInfo['firstName']. '</h2>';
echo'<h2>Last Name: '.$profilInfo['lastName']. '</h2>';
echo'<h2>HeadLine: '.$profilInfo['headline']. '</h2>';
echo'<h2><a href="'.$profilInfo['profilUrl'].'"> LinkedIn Profile </a></h2>';

// Get User's Status
$userStatus = $linkedin->getStatus();

// Display User's Status
if(!empty($userStatus))
{
	echo"<h2>Statut Of  ".$profilInfo['firstName'] . ' ' . $profilInfo['lastName'] .": 
	$userStatus </h2>";
}
else
{
	echo'<h2>No Status</h2>';
}


// Modify User's LinkedIn Status	 
$linkedin->updateStatus('is Building a PHP Class to Update Status');

// Get The New Status
$userStatus = $linkedin->getStatus();

// Display User's LinkedIn Status
if(!empty($userStatus))
{
	echo"<h2>Statut Of  ".$profilInfo['firstName'] . ' ' . $profilInfo['lastName'] .": 
	$userStatus </h2>";
}
else
{
	echo'<h2>No Status</h2>';
}


// Clear User's LinkedIn Status 
$linkedin->clearStatus();	 

// Get Status
$userStatus = $linkedin->getStatus();

// Display User's Status
if(!empty($userStatus))
{
	echo"<h2>Statut Of  ".$profilInfo['firstName'] . ' ' . $profilInfo['lastName'] .": 
	$userStatus </h2>";
}
else
{
	echo'<h2>No Status</h2>';
}

// The END! ;)	

?>