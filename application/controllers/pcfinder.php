<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pcfinder extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
        $this->load->model('postalcode_model');
        $this->load->library('form_validation');
    }

        /**
         * return and display a multidimensional array of parishes
         * to generate a GeoJSON file used with mapbox.js
         *
         * @return array|null
         */
    public function map()
    {
        $this->load->model('postalcode_model','get_postal');
        
        if ($this->postalcode_valid($this->input->post('postalString'))){
        $search = $this->input->post('postalString');
            
            $search_clean = preg_replace('/\s*/', '', $search);
            // convert the string to all lowercase
            $search_clean2 = strtolower($search_clean);
            
            if (!empty($search))
                {
                $query= $this->get_postal->map_postalcode($search_clean2);
                if ($query !== "No results found" )
                {
                    foreach($query as $row){
                        $data[] = $row;
                    }
                    echo json_encode(array('postalcode_finder' =>$data));
                }else{echo "not valid"; }
                }else
                {   echo "not valid";   }
        }
        
    }
    
 public function postalcode_valid($str)
    {
        /*Regex code Validates Postal code for the following
         *T2C
         *T2S3W4
         *V2S-7K3
         *V2S 7K3
         */
          $postalCode = strtoupper($str);
          $postalCode = str_replace(" ", "", $postalCode);
          $postalCode = str_replace("-", "", $postalCode);

          if( preg_match("/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/",$postalCode)||
             preg_match("/^([A-Za-z]\d[A-Za-z][-]?\d[A-Za-z]\d)$/",$postalCode) ||
             preg_match("/^([A-Za-z]\d[A-Za-z])$/", $postalCode))
          {
              return true;
          }else{
         
              $this->form_validation->set_message('postalcode_valid', 'Incorrect Postal Code ');
              return false;
          }
        
    }  
    
}