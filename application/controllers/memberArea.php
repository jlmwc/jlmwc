<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MemberArea extends CI_Controller{	

	public function __construct()
	{
	   parent::__construct();
	   $this->load->library('form_validation');
	   $this->load->model('parishfinder_model',TRUE); 
	}
	
	
	public function index()
	{
	    if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
	      $data['selected'] = $this->parishfinder_model->list_City_Church();
	     	
	      $this->load->view('administration/memberArea_search', $data);
	      
	    }else
	    {
	      //If no session, redirect to login page
	      redirect('login', 'refresh');
		}
	}
	
	public function logout()
	{
	    $this->session->unset_userdata('logged_in');
	    session_destroy();
	    redirect('memberArea', 'refresh');
	}
	
	public function search()
	{
		$this->form_validation->set_rules('searchParishName', 'searchParishName', 'trim|required|xss_clean');
		$searchParishName = $this->input->post('search');
			if ( $this->parishfinder_model->searchAllParishChurch( $searchParishName ) != false )
			{	
				$data['html'] = $this->parishfinder_model->searchAllParishChurch( $searchParishName );
				$this->load->view('administration/search_results_view', $data);
				
			}else{
				$data['searchError'] = 'No results found Please Try again';
				$this->load->view('administration/search_results_view', $data);
			}
	}
	
	public function searchCity()
	{
		$this->form_validation->set_rules('searchParishName', 'searchParishName', 'trim|required|xss_clean');
		$searchParishCity = $this->input->post('citySelected');
		if ( $this->parishfinder_model->searchAllCity() != false )
		{	
			$data['html']= $this->getCity($searchParishCity);
 			$this->load->view('administration/search_results_view', $data);
		}else{
			$data['searchError'] = 'No results found Please Try again';
			$this->load->view('administration/search_results_view', $data);
		}
	}
	
	public function getCity($searchParishCity)
	{
		
		$data['html'] = $this->parishfinder_model->searchAllCity();
		foreach($searchParishCity as $city){
			for ($j=0; $j<count($data['html']); $j++)
			{
				if ($city == $data['html'][$j]['City'])
				{
					
					if(!isset($data['city']))
					{
						$data['city'] = array();
					}	
					$data['city'][] = $data['html'][$j];
					
				}
				
 			}
		}
		return $data['city'];			
	}
	
	public function editChurch(){		
		$_churchID = $this->uri->segment(3);
		$churchDetails  = array();
	    $address = array();
	    $phone = array();
	    $social = array();
	    $website = array();
	        
	    array_push($churchDetails,
	    		   array('ChurchInfo' => $this->parishfinder_model->getChurchName($_churchID)),
	               array('addressDetails' => $this->parishfinder_model->listaddress_church($_churchID)),
	               array('phoneDetails' => $this->parishfinder_model->listphone_church($_churchID)),
	               array('socialDetails' => $this->parishfinder_model->listsocial_church($_churchID)),
	               array('websiteDetails' => $this->parishfinder_model->website_church($_churchID)),
	               array('eventsDetails'=> $this->parishfinder_model->getAllEvents($_churchID))
	              );
		$data['churchDetails'] = $churchDetails;
		$this->load->view('administration/churchDetail', $data);
	}
}
	
/*EOF: MemberArea.php*/