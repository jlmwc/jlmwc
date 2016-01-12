<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postalcode_model extends CI_Model
{

	/**
	 * preload postalcodes database
	 */
	public function __construct()
	{
		// initialize postalcode database
		//$PC = $this->load->database('postalcodes', TRUE);
	}


	/**
	 * process uri request with postal code or postal code snippet and
	 * returns the most likely postal code and its longitude and latitude
	 *
	 * @return key pair array | null postalcode longitude and latitude
	 */
	function map_postalcode($postalcode)
	{
		// query postalcode DB
		$sql = '
			SELECT PostalCode, Latitude, Longitude
			FROM canada_codes
			WHERE PostalCode LIKE "'.$this->db->escape_like_str($postalcode).'%"
			LIMIT 1';

		//TODO error handle where no results are returned

        $sql_query = $this->db->query($sql);
		if($sql_query->num_rows() > 0){

        foreach($sql_query->result_array() as $row){
				$data[] = $row;
        }


        return $data;

        }else{
            return "No results found";
        }

	}
}

/* End of file postalcode_model.php */
/* Location: ./application/models/postalcode_model.php */
