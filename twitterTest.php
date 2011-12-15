<?php
/*
 * 1. Obtain Request token
 * 2. Redirect the User.
 * 3. Converte Request token to an access token.
 */

function post_request($url, $data){
	$data = http_build_query($data);
	$url = parse_url($url);
	
	if ($url['scheme']!='http'){
		die('Error: Only HTTP request are supported !');
	}
	
	$host = $url ['host'];
	$path = $url['path'];
	
	//Open a socket connection on port 80 - timeout: 30 sec
	$fp = fsockopen($host, 80, $errno, $errstr, 30);
	
	if ($fp){
		//Send request headers
		fputs($fp, "POST /oauth/request_token HTTP/1.1");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "Accept: */*");
		fputs($fp, "Authorization:");
		fputs($fp, "OAuth oauth_callback =" . $data['callback']);
		fputs($fp, "oauth_consumer_key = " . $data['consumer_key']);
		fputs($fp, "oauth_nonce = " . $data['nonce']);
		fputs($fp, "oauth_signature = " . $data['signature']);
		fputs($fp, "oauth_signature_method = " . $data['signature_method']);
		fputs($fp, "oauth_timestamp = " . $data['timestamp']);
		fputs($fp, "oauth_version = " . $data['version']);
		
		$result = '';
		while(!feof($fp)) {
			// receive the results of the request
			$result .= fgets($fp, 128);
		}
	}
	
	else{
		return array(
		            'status' => 'err', 
		            'error' => "$errstr ($errno)"
		);
	}
	
	fclose($fp);
	
	// split the result header from the content
	$result = explode("\r\n\r\n", $result, 2);
	
	$header = isset($result[0]) ? $result[0] : '';
	$content = isset($result[1]) ? $result[1] : '';
	
	// return as structured array:
	return array(
	        'status' => 'ok',
	        'header' => $header,
	        'content' => $content
	);
}



	$oauth_data = array(
		'callback' => "http://recrusocial.co.cc",
		'consumer_key' => "uiv8cTl50JYzyzoDIrmZg",
		'nonce' => "",
		'signature'=> "",
		'signature_method' => "",
		'timestamp' => time(),
		'version' => "1.0"
		);
	
	$result = post_request('api.twitter.com', $oauth_data);
	
	
?>