<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	session_start();
	
	class CRUDChurchDetail extends CI_Controller {	

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
	    }else
	    {
	      //If no session, redirect to login page
	      redirect('login', 'refresh');
		}
	}
	
	/*
	*TODO change update to getChurchAdddress or edit
	*/
	
	public function updateChurchaddress()
	{   $data['city'] = $this->parishfinder_model->list_City_Church();
		$data['province'] = $this-> parishfinder_model->list_dropdown('idProvince', 'Abbreviation', 'Province');
		
		
		$cid = $this->input->post('cid');
		$data['addressType'] = $this->parishfinder_model->list_dropdown('idAddressType', 'AddressType', 'AddressType');
		$churchAddress  = array();
		array_push($churchAddress,array('addressDetails' => $this->parishfinder_model->listaddress_church($cid)));
		$data['churchAddress'] = $churchAddress;
		$this->load->view('administration/updateChurchAddress', $data);
	}
	
	public function updateChurchphone()
	{   $data['phone'] = $this-> parishfinder_model->list_dropdown('idPhoneType', 'PhoneType', 'PhoneType');
		$data['web'] = $this-> parishfinder_model->list_dropdown('idWebType', 'WebType', 'WebType');
		$cid = $this->input->post('cid');
		$data['addressType'] = $this->parishfinder_model->list_dropdown('idAddressType', 'AddressType', 'AddressType');
		$churchPhone  = array();
		
		array_push( $churchPhone,array('phoneDetails' => $this->parishfinder_model->listphone_church($cid)) );
		$data['churchPhone'] = $churchPhone;
		$this->load->view('administration/updateChurchPhone', $data);	
	}
	
// 	public function updateChurchsocial(){}
	public function updateChurchwebsite()
	{
		$data['phone'] = $this-> parishfinder_model->list_dropdown('idPhoneType', 'PhoneType', 'PhoneType');
		$data['web'] = $this-> parishfinder_model->list_dropdown('idWebType', 'WebType', 'WebType');
		$data['email'] = $this-> parishfinder_model->list_dropdown('idEmailType', 'EmailType', 'EmailType');
		$cid = $this->input->post('cid');
		$data['addressType'] = $this->parishfinder_model->list_dropdown('idAddressType', 'AddressType', 'AddressType');
		$churchWebsite  = array();
		array_push($churchWebsite,array('websiteDetails' => $this->parishfinder_model->website_church($cid)));
		$data['churchWebsite'] = $churchWebsite;
		$this->load->view('administration/updateChurchWebsite', $data);
	}
	
	
	public function addChurchInfo()
	{	
		
		$data['addressType'] = $this->parishfinder_model->list_dropdown('idAddressType', 'AddressType', 'AddressType');
		$data['city'] = $this->parishfinder_model->list_City_Church();
		$data['province'] = $this-> parishfinder_model->list_dropdown('idProvince', 'Abbreviation', 'Province');
		$data['phone'] = $this-> parishfinder_model->list_dropdown('idPhoneType', 'PhoneType', 'PhoneType');
		$data['web'] = $this-> parishfinder_model->list_dropdown('idWebType', 'WebType', 'WebType');
		$this->load->view('administration/addChurch', $data);
		
	}
	
	public function updateChurchEvents()
	{
		$cid = $this->input->post('cid');
		$eid = $this->input->post('eid');
		$data['eventType'] = $this->parishfinder_model->list_dropdown('idEventType', 'EventType', 'EventType');
		$data['language'] = $this->parishfinder_model->list_languages_Church();
		$events['events'] = $this->parishfinder_model->getAllEvents($cid);
		foreach( $events['events'] as $row)
		{
			if ($eid == $row['EventID'])
			{
				$data['EventID'] = $row['EventID'] ;
				$data['Schedule'] = $row['Schedule'];
				$data['dayOfWeek'] = $row['dayOfWeek'];
				$data['Holidays'] = $row['Holidays'];
				$data['HolidayRecord'] = $row['HolidayRecord'];
				$data['StartTime'] = $row['StartTime'];
				$data['EndTime'] = $row['EndTime'];
				$data['Active'] = $row['Active'];
				$data['idEventType'] = $row['EventType'];
				$data['EventType'] = $row['EventType'];
			}
		}
		$data['cid'] = $cid;
		
		$this->load->view('administration/updateChurchEvents', $data);
	}
	public function addChurchEvents()
	{
	
		$this->load->view('administration/addChurchEvents');
	}
}

/*EOF: editChurch.php*/
	
	