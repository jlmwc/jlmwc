<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class postfinder extends CI_Controller {

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
    public function postFinder() {
        $churchname = false;
        $eventtype = false; 
        $languageSelector = false;
        $days = false;
        $userValues = array();
        
        if ($this->input->post('churchString')){
        $name_of_church= $this->input->post('churchString');
        $userValues['Church'] = $name_of_church;
        $churchname= true;
        }
        if (is_array($this->input->post('eventType'))){
            $event_type=$this->input->post('eventType');
            $lengthpostInput = sizeof($event_type);
            for($i=0; $i<$lengthpostInput; $i++){
               $userValues['EventTypeID'][$i] = $event_type[$i];
            }
            
            $eventtype = true;
        }
        if (is_array($this->input->post('languageSelector'))){
            $language_selector= $this->input->post('languageSelector');
            $lengthpostInput = sizeof($language_selector);
            for($i=0; $i<$lengthpostInput; $i++){
               $userValues['Language'][$i] = $language_selector[$i];
            }
            $languageSelector = true;
        }
        if ($this->input->post('daysofweek')){
            $days_of_week= $this->input->post('daysofweek');
            $userValues['day'] = $days_of_week;
            $days = true;
        }
        if ($this-> input -> post('cityString')){
            $city = $this-> input -> post('cityString');
            $userValues['city'] = $city;
        }
       
        
       $stringData ="";
       foreach ($userValues as $key => $value){ 
           switch (true){
               case($key ==="Church"):               
                    if(strlen($value) > 0 ){
                      $church_name = 'Church LIKE \'%'.$value.'%\' ';
                        $stringData.= $church_name;
                    }
               break;
               case($key ==="Language"):
               if (sizeof($value) > 0){
                    if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                foreach($value as $key1 => $value1)
                  {
                            if ($key1 == 0){
                                $stringData.= "(".$key." = '".$value1."'";
                                }else{
                                $stringData.= " OR ".$key." = '".$value1."'";
                                }
                    }
                    $stringData.= ")";
               }
               break;
               
               case($key ==="EventTypeID"):
               if (sizeof($value) > 0){
                    if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                foreach($value as $key1 => $value1)
                  {
                            if ($key1 == 0){
                                $stringData.= "(".$key." = '".$value1."'";
                                }else{
                                $stringData.= " OR ".$key." = '".$value1."'";
                                }
                    }
                    $stringData.= ")";
               }
                   break;
               case($key ==="day"): 
               if (strlen($value) > 0 ){
                    if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                   $stringData.= " ".$value." = '1' ";

                    }
               break;
               case($key ==="city"): 
               if(strlen($value) > 0 ){
                   if ($stringData != "" )
                    {
                        $stringData.=" AND ";
                    }
                      $city = 'CityName ="'.$value.'"';
                      $stringData.= $city;
                    }
               break;
           }
           
       }
        
        if ($eventtype == false && $days == false){
            $where= "Where ".$stringData;
            $query= $this->parishfinder_model->list_parishes($where);
            if (!empty($query)){
            foreach($query as $row){
                $data[] = $row;
            }
            echo json_encode(array('parish_finder' =>$data));
            }
            else{
            echo "No results found.";
            }
        }else{
            $where= "Where ".$stringData;
            $query = $this->parishfinder_model->list_events_Church($where);
            foreach($query as $row){
                $data[] = $row;
            }
            echo json_encode(array('events_finder' => $data));
            }
        }
}

?>