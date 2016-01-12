<?php
	// require_once('ConvioOpenAPI.php');

		//Object Instantiated 
		
		
		//public Variables
		public $callString= NULL; 
		public $paramsArray = array();
	
		//Functions
		
		public function ConvioAPICall ($name, $password, $APICall){
			$convioAPI = new ConvioOpenAPI;
		
			// Authentication Configuration
			$convioAPI->login_name     = $name;
			$convioAPI->login_password = $password;
			// Set API Parameters
			$params = $paramsArray;
			// Make API call (ApiServlet_apiMethod)
			
			return $convioAPI->call($APICall);
		}
				
		
		public function decodestring($jsonString) {
			$decodeString = json_decode($jsonString);
			print_r($decodeString);
		}
		
		
		//get user groups egcontroller to model
		

		model side				
		public function validJstring($arrayValue){
			print_r($arrayValue);
			if (!array_key_exists('errorResponse', $arrayValue)) return true; else return false;	
		
		}
		

		public function checkUser($userString){
			$arrayUser = json_decode($userString, true);
		
// 		print_r($arrayUser['loginResponse']['cons_id']);

			if ( $this->validJstring($arrayUser) && array_key_exists('cons_id', $arrayUser['loginResponse']))return true; else return false;
		}
		
		public function checkGroup($groupString)
		{
			
			if ( validJstring($jsonUserString) && !array_key_exists('', $jsonUserString)) return true; else return false;		}

		
		
// 		private function __startSession(){}
		
		public function validateUser( $jsonUserString , $jsonUserString ){
		
				
				if( $this->checkUser( $jsonUserString && this->checkGroup() )){
					
					return true;
						
			}else{
				
				return false;
				}	
		}
	
