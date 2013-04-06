<?php

class RewardStyle{
	public $client_id;
	public $client_secret;
	public $redirect;
	function __construct(){
		$this->client_id = "YOUR-CLIENT-ID";
		$this->client_secret= "YOUR-CLIENT-SECRET";
		$this->redirect = "YOUR-REDIRECT-URI";
	}
	
	public function sendCode($code){
		/*curl -X POST \
			-F 'client_id=YOUR-CLIENT-ID' \
			-F 'client_secret=YOUR-CLIENT-SECRET' \
			-F 'code=YOUR-AUTH-CODE' \
			https://api.rewardstyle.com/oauth/token
		*/
		$url = 'https://api.rewardstyle.com/oauth/token';
		$fields = array(
			'client_id' => urlencode($this->client_id),
			'client_secret' => urlencode($this->client_secret),
			'code' => urlencode($code),
		);

		//url-ify the data for the POST
		$fields_string = "";
		foreach($fields as $key=>$value) { 
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//execute post
		$result = curl_exec($ch);
		$token_array = json_decode($result, true);
		
		
		$_SESSION['token'] = $token_array["access_token"];
		header("Location: /");
		
		
	}
	
	public function authenticate(){
		header("Location: https://api.rewardstyle.com/oauth/authorize?client_id="
		  .$this->client_id."&redirect_uri="
		  .urlencode($this->redirect)
		  ."&scope=favorites");	
	}
	
}