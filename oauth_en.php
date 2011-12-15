<?php

/*
*
* @abstract: Cette Classe sert a accéder a l'API de LinkedIn en utilisant l'Authentification Oauth Authentication Protocol
* @author: Christophe Fiat
* @version: 0.2 2009-12-06
* @copyright: FormatiX.EU
*
*/

class linkedIn
{

	private $options;
	private $consumer;
	private $client;
	private $token;

	public function __construct($params)
	{
		// Add Zend and Zend Incubator Paths to the Include Path
		set_include_path( $params['zendPath'] . PATH_SEPARATOR .  $params['zendIncubatorPath'] . PATH_SEPARATOR . get_include_path() );

		// Include Oauth Consumer class definition
		require_once('Zend/Oauth/Consumer.php');

		// Set Zend_Oauth_Consumer options
		$this->options = array(
		'version' => '1.0',
		'localUrl' => $params['localUrl'],
		'callbackUrl' => $params['callbackUrl'],
		'requestTokenUrl' => 'https://api.linkedin.com/uas/oauth/requestToken',
		'userAuthorisationUrl' => 'https://api.linkedin.com/uas/oauth/authorize',
		'accessTokenUrl' => 'https://api.linkedin.com/uas/oauth/accessToken',
		'consumerKey' => $params['consumerKey'],
		'consumerSecret' => $params['consumerSecret']
		);
		
		if( isset( $_GET["about"] ) ) echo '<br/><a href="http://www.formatix.eu/"> Powered By Formatix </a><br/>';

		// Instanciate Zend_Oauth_Consumer Class
		$this->consumer = new Zend_Oauth_Consumer( $this->options );

	}

	public function connect()
	{
		// Start Session to be able to store Request Token &amp; Access Token
		session_start ();

		if ( !isset ( $_SESSION ['ACCESS_TOKEN'] )) {
			// We do not have any Access token Yet
			if (! empty ( $_GET )) {
				// But We have some parameters passed throw the URL

				// Get the LinkedIn Access Token
				$this->token = $this->consumer->getAccessToken ( $_GET, unserialize ( $_SESSION ['REQUEST_TOKEN'] ) );

				// Store the LinkedIn Access Token
				$_SESSION ['ACCESS_TOKEN'] = serialize ( $this->token );
			} else {
				// We have Nothing

				// Start Requesting a LinkedIn Request Token
				$this->token = $this->consumer->getRequestToken ();

				// Store the LinkedIn Request Token
				$_SESSION ['REQUEST_TOKEN'] = serialize ( $this->token );

				// Redirect the Web User to LinkedIn Authentication Page
				$this->consumer->redirect ();
			}
		} else {
			// We've already Got a LinkedIn Access Token

			// Restore The LinkedIn Access Token
			$this->token = unserialize ( $_SESSION ['ACCESS_TOKEN'] );

		}

		// Use HTTP Client with built-in OAuth request handling
		$this->client = $this->token->getHttpClient($this->options);

	}
	
	/* 
	* @abstract: This Method Grabs LinkedIn User Profile from LinkedIn API
	*/
	public function whoAmI()
	{
		// Set LinkedIn URI
		$this->client->setUri('https://api.linkedin.com/v1/people/~');
		// Set Method (GET, POST, PUT, or DELETE)
		$this->client->setMethod(Zend_Http_Client::GET);
		// Execute Request and get Response
		$response = $this->client->request();

		// Get the XML containing User's Profile
		$content =  $response->getBody();

		// Uncomment Following Line To display XML result
		// header('Content-Type: ' . $response->getHeader('Content-Type'));
		// echo $content;
		// exit;

		// Use Php simplexml to transform XML to a PHP Object
		$xml = simplexml_load_string($content);

		// Uncomment Following Lines To display Simple XML Object Structure
		// echo '<pre>';
		// print_r($xml);
		// echo'</pre>';

		// Uncomment Following Lines To display LinkedIn User Profile
		// echo 'First Name: ' . $xml->{'first-name'};
		// echo '<br/>';
		// echo 'Last Name: ' . $xml->{'last-name'};
		// echo '<br/>';
		// echo 'Headline: ' . $xml->{'headline'};
		
		// Put the User Profile info in an Array
		$info['firstName']  = (string) $xml->{'first-name'}; 
		$info['lastName']   = (string) $xml->{'last-name'}; 
		$info['headline']   = (string) $xml->{'headline'}; 
		$info['profilUrl'] = (string) $xml->{'site-standard-profile-request'}->url;

		// Return the Array as result
		return $info;	
	}
	
	/* 
	* @abstract: Creates THE XML string containing the User Status
	*/
	private function createXmlStatus($status)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?><current-status>'.$status.'</current-status>';
		
		return $xml;			
	}	
	
	/* 
	* @abstract: Gets the User's LinkedIn Status
	*/	
	public function getStatus()
	{
		// Set LinkedIn's GetStatus URI
		$this->client->setUri('http://api.linkedin.com/v1/people/~:(current-status)');

		// Set HTTP Method (GET, POST, PUT, or DELETE)
		$this->client->setMethod(Zend_Http_Client::GET);
		
		// Execute Request and get Response
		$response = $this->client->request();

		// Get the XML containing User's Status
		$content =  $response->getBody();
		
		// Use Php simplexml to transform XML to a PHP Object
		$xml = simplexml_load_string($content);

		// Store Status
		$status = (string) $xml->{'current-status'};
		
		// Return Status as result
		return $status;
		
	}
	public function updateStatus($status)
	{
		// Set LinkedIn's Set Status URI
		$this->client->setUri('https://api.linkedin.com/v1/people/~/current-status');
		
		// Set HTTP Method (GET, POST, PUT, or DELETE)
		$this->client->setMethod(Zend_Http_Client::PUT );
		
		// Create XML String containing Users Status to be passed with the PUT
		$xml = $this->createXmlStatus($status);
		
		// Attach the XML String to the HTTP request
		$this->client->setRawData($xml,'text/xml');
		
		// Set the Content Type in the HTTP Header
		$this->client->setHeaders('Content-Type', 'text/xml');
		
		// Execute Request
		$this->client->request();
		
	}
	
	public function clearStatus()
	{
		// Set LinkedIn's Clear Status URI
		$this->client->setUri('https://api.linkedin.com/v1/people/~/current-status');
		
		// Set HTTP Method (GET, POST, PUT, or DELETE)
		$this->client->setMethod(Zend_Http_Client::DELETE );
		
		// Execute Request
		$this->client->request();
		
	}	
	
	

} // Class End

 

?>