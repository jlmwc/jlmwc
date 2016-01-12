<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class postfinder extends CI_Controller 
{

    public function __construct()
    {
//      TODO initialize Parishfinder GET function (parse key pair array)
      parent::__construct();
        $this->load->model('parishfinder_model');
    }
    
    /*
    *@param - no params, input values acquired from post 
    *
    * @return - array information with coordinates, longitude and latitude
    *  
    * 
    */
    
    public function postFinder() 
    {
            $churchname = false;
            $city = false;
            $eventtype = false;
            $userValues = array();
        
        if ($this->input->post('churchString')){
            $name_of_church= $this->input->post('churchString');
            $userValues['Church'] = str_replace(array('.', ',', "'",'"', '$', '*', ':', ';', '!', ' '), '%' , $name_of_church);
            $churchname= true;
        }

        if ($this-> input -> post('cityString')){
            $city = $this-> input -> post('cityString');
            $userValues['city'] = $city;
            $city = true;
        }
       
        
       $stringData ="";
       foreach ($userValues as $key => $value)
       { 
           switch (true)
           {
               case($key ==="Church"):               
                    if(strlen($value) > 0 ){
                      $church_name = 'Church LIKE \'%'.$value.'%\'';
                        
                        $stringData.= $church_name;
                    }else{
                        $church_name = '';
                        $stringData.= $church_name;
                    }
               break;
               case($key ==="city"): 
               if(strlen($value) > 0 ){
                   if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                      $city = 'City ="'.$value.'"';
                      $stringData.= $city;
               }else{
                   if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                      $city = '';
                      $stringData.= $city;
               }
               break;
           }
           
       }

        if ($churchname= true && $city = true){
            if (!empty($stringData)){
            $where = "Where ".$stringData;
            }else{$where = ""; }
            $query= $this->parishfinder_model->list_churches($where);
            if (!empty($query)){
              foreach($query as $row){
                  $data[] = $row;
              }
               
              echo json_encode(array('parish_finder' => $data));
            }else{
            echo "No results found.";
            }
        }
    }
    
    
    
    public function churchDetails(){
    $_churchID = $this->input->get('churchID');
    
//     var_dump()
    $churchDetails  = array();
    $address = array();
    $phone = array();
    $social = array();
    $website = array();
        
    array_push($churchDetails,
               array('addressDetails' => $this->parishfinder_model->listaddress_church($_churchID)),
               array('phoneDetails' => $this->parishfinder_model->listphone_church($_churchID)),
               array('socialDetails' => $this->parishfinder_model->listsocial_church($_churchID)),
               array('websiteDetails' => $this->parishfinder_model->website_church($_churchID))
              );
    echo json_encode(array('church_details' => $churchDetails));
    }
    
    public function parishDetails()
    {
   
	    $_parishID = $this->input->get('parishID');
	    $parishData  = array();
	    $parishDetails = array();

        
		array_push($parishData, array('parishinfo' => $this->parishfinder_model->find_parishes($_parishID) ));
        
	        foreach ($parishData as $value) 
	        {
	            foreach ($value as $key)
	            {
	                for ($x = 0; $x < sizeof($key); $x++) 
	                {              
	                    array_push($parishDetails,
	                               array('id'=>$key[$x]['idChurch'],
	                                     'addressDetails' => $this->parishfinder_model->listaddress_church( $key[$x]['idChurch']) ),
	                               array('id'=>$key[$x]['idChurch'],
	                                     'phoneDetails' => $this->parishfinder_model->listphone_church( $key[$x]['idChurch']) ),
	                               array('id'=>$key[$x]['idChurch'],
	                                     'socialDetails' => $this->parishfinder_model->listsocial_church( $key[$x]['idChurch']) ),
	                               array('id'=>$key[$x]['idChurch'],
	                                     'websiteDetails' => $this->parishfinder_model->website_church( $key[$x]['idChurch']) ), 
	                               array('id'=>$key[$x]['idChurch'],
	                                     'eventDetails' => $this->parishfinder_model->list_events_Church( $key[$x]['idChurch']) ),
	                               array('id'=>$_parishID,
	                                     'clergyDetails' => $this->parishfinder_model->clergy_church( $_parishID ))
	                              );
	                    }
	            }
	        }
    
			echo json_encode(array ('parishdetails' => $parishDetails,'parish' => $parishData));
    }
    
}

?>