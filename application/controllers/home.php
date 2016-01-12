<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Home extends CI_Controller{

		public function index(){
			$this->load->view('maphome/mapper');
			$this->load->model('parishfinder_model');
		}

        public function cleanString($cleanStr){
            trim($cleanStr);
            $search = preg_replace("/[^a-zA-Z.]/", "", $cleanStr);
             $search = strtolower($search);
            return $search;
        }

        public function getCity(){

        $this->load->model('parishfinder_model');

        foreach($this->parishfinder_model->list_City_Church() as $row){
                    $data[] = array (
                'idCity' => $row['idCity'],
                'City' => $row['City'],
                );
        }

       echo json_encode($data);

        }
        
    
    public function show_churches()
	{
		$map = array();
		$data = array();

        $this->load->model('parishfinder_model');
		foreach($this->parishfinder_model->map_features() as $key) :

			$key = (array) $key;
          
			// generate the coordinates
			$coordinates = array(
				($key['Longitude'])+0,
				($key['Latitude'])+0
			);
			$geometry = array(
				'coordinates' => $coordinates,
				'type' => 'Point'
			);
            
			$key['title'] = $key['Church'];
			$key['marker-symbol'] = $key['Icon'];
			$key['marker-color'] = '#dd5252';
            $key['areaCode'] = $key['AreaCode'];
            $key['ChurchID'] = $key['idChurch'];
            $key['phone']= $key['Phone'];
            $key['email']= $key['Email'];
            $key['WebsiteUrl']= $key['WebsiteUrl'];
            $key['PhoneType'] = $key['PhoneType'];

			// generate the features
			$feature = array(
				'type' => 'Feature',
				'geometry' => $geometry,
				'properties' => $key
			);

			array_push($map, $feature);

		endforeach;

		$data['map'] = $map;

		$this->load->view('geojson', $data);
	}

}
?>