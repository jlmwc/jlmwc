<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // load the updater model
    public function index() {
	    parse_str($_SERVER['QUERY_STRING'],$_GET); //converts query string into global GET array variable
 		var_dump($_GET);  //test the $_GET variables
		/*
			Variables declaration
		*/
		
		
		$idAddress		= '';
		$idWeb			= '';
		$idPhone		= '';
		$idAddressType 	= '';
		$idEmail		= '';
		$idChurch		= '';
		$idCity			= NULL;
		$idProvince		= NULL;
		$idCountry		= '1';//Canada Default Country
		$Street1		= '';
		$Street2		= NULL;
		$rr				= NULL;
		$stn			= NULL;
		$po				= NULL;
		$gd				= NULL;
		$PostalCode		= NULL;
		$Longitude		= NULL;
		$Latitude		= NULL;
		$idPhoneType	= '';
		$idClergy		= NULL;
		$AreaCode		= '';
		$Phone			= '';
		$Extension		= NULL;
		$idWebType		= '';
		$Url			= '';
		$idEmailType	= '';
		$Email			= '';
		
		
		$idAddress		= $this->input->get('idAddress');
		$idWeb			= $this->input->get('idWeb');
		$idPhone		= $this->input->get('idPhone');
		$idAddressType 	= $this->input->get('AddressType');
		$idChurch		= $this->input->get('cid');
		$idCity			= $this->input->get('idCity');
		$idProvince		= $this->input->get('idProvince');
		$Street1		= $this->input->get('Street1');
		
/*
		$Street2		= $this->input->get('');
		$rr				= $this->input->get('');
		$stn			= $this->input->get('');
		$po				= $this->input->get('');
		$gd				= $this->input->get('');
*/
		$PostalCode		= $this->input->get('PostalCode');
		$Longitude		= $this->input->get('Longitude');
		$Latitude		= $this->input->get('Latitude');
		$idPhoneType	= $this->input->get('idPhoneType');
// 		$idClergy		= $this->input->get('');
		$AreaCode		= $this->input->get('AreaCode');
		$Phone			= $this->input->get('Phone');
// 		$Extension		= $this->input->get('');
		$idWebType		= $this->input->get('WebsiteType');
		$Url			= $this->input->get('Url');
		$idEmailType	= $this->input->get('idEmailType');
		$Email			= $this->input->get('Email');
		$idEmail 		= $this->input->get('idEmail');
		
		var_dump($idEmail);
		$this->load->model('parishfinder_model',TRUE);
 		     
		if ( $idAddress && $idAddressType && $idCountry&&$idChurch && $idCity && $idProvince && $Street1 && $PostalCode && $Longitude && $Latitude ){
			echo "in address";
			$this->parishfinder_model->updateAddress($idAddress,$idAddressType,$idChurch,$idCountry,$idCity,$idProvince,$Street1,$PostalCode,$Longitude,$Latitude);
		}else if ($idPhoneType && $AreaCode && $Phone ){
			echo "in phone";
			$this->parishfinder_model->updatePhone($idChurch,$idPhone,$idPhoneType,$AreaCode,$Phone);
		}else if ($idWeb && $idWebType && $Url && $idEmailType && $Email && $idEmail){
			echo "in website";
			$this->parishfinder_model->updateWebsite($idChurch,$idWeb,$idWebType,$Url);
			$this->parishfinder_model->updateEmail($idChurch,$idEmail,$idEmailType,$Email );
		}
		
 		$this->load->view('test.php');
    }




}

/* End of file update.php */
/* Location: ./application/controllers/update.php */
