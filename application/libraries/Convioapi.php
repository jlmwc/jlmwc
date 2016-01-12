<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Convioapi
{
	//public assigned variables
	public $host = 'secure2.convio.net';
	public $short_name = 'rcbdc';
	public $api_key = 'rcbdcapi';
	public $v = '1.0';
	public $response_format = 'json';

	//private variables
	private $__method;
	private $__methodParams = array();
	private $__servlet;

	public function __construct($data = array())
	{
		$this->CI =& get_instance();

		if (count($data) > 0 ){
		 	foreach ($data as $key )
		 	{
		 		$login_name = $data['username'];
		 		$login_password = $data['password']; 
		 		$servletMethod = $data['servletMethod'];
	 			}	 
			}else{
				$login_name = NULL;
				$login_password = NULL;
				$servletMethod;
			}


		$this->call($servletMethod);
	}

	private function __getPostData()
	{
		$response_format = $this->response_format;
		if ($this->response_format == 'php') $response_format = 'json';
		$baseData   = http_build_query(array('v'=>$this->v,'api_key'=>$this->api_key,'response_format'=>$response_format,'login_name'=>$this->login_name,'login_password'=>$this->login_password,'method'=>$this->__method));
		$methodData = http_build_query($this->__methodParams);
		return sprintf('%s&%s', $baseData, $methodData);
	}

	private function __makeCall()
	{
		$url  = $this->__getUrl();
		$post = $this->__getPostData();

		// Here is where we check for cURL. If we don't find it we make a fopen call...
		if (function_exists('curl_exec') === FALSE)
		{
			$context = stream_context_create(array('http'=>array('method'=>'POST','content'=>$post)));
			$fp = @fopen($url, 'rb', FALSE, $context);
			$response = @stream_get_contents($fp);
			@fclose($fp);

			if ($response == '') $response = sprintf("The server returned no useable data. This likely points to a NULL result. Try installing php-curl for better error handling.\n");
		}
		
		else
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($curl);

			if ($response == '') $response = sprintf("cURL Error %s: %s\n", curl_errno($curl), curl_error($curl));

			curl_close($curl);
		}

		if ($this->response_format == 'php') $response = json_decode($response);

		return $response;
	}

	private function __getUrl()
	{
		return sprintf('https://%s/%s/site/%s', $this->host, $this->short_name, $this->__servlet);
	}

	public function call($servletMethod, $params = NULL)
	{
		$this->__servlet = array_shift(explode('_', $servletMethod));
		$this->__method  = array_pop(explode('_', $servletMethod));
		if ($params !== NULL) $this->__methodParams = $params;
		return $this->__makeCall();
	}

}

//EOF: ConvioAPI
