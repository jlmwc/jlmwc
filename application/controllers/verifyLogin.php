<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('convioapi','',TRUE);
   $this->load->library('form_validation');
   
  }

 function index()
 {
   //This method will have the credentials validation
   
   
	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_checkConvio');

	if ($this->form_validation->run() == false)
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$this->load->view('administration/memberArea_search'); //member search area
		}else
		{	
			$this->load->view('administration/login'); //login 
		}
	}
   else
   {
     //Go to private area
     redirect('memberArea', 'refresh');
   }

 }

 function checkConvio($password)
 {
   //Field validation succeeded.  Validate against database
   $login_name = $this->input->post('username');

   //query the database
   $result = $this->convioapi->login($login_name, $password);

   if($result)
   {
     $sess_array = array();
	 
     foreach($result as $row)
     {
	     
       $sess_array = array(
         'username' => $row['user_name'],
         'email' => $row['email']['primary_address']
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }

     return TRUE;
   }else
   {
      $this->form_validation->set_message('checkConvio', 'Invalid username or password');
     return false;
   }
 }
}

//EOF: verifyLogin