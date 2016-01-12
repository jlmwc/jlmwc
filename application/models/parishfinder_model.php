<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parishfinder_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

		/**
		 * processes query to return all available addresses that contain
		 * longitude and latitude information - intended to be parsed into GeoJSON
		 * data for mapbox
		 *
		 * @return key pairs|null of fields
		 */
		function map_features()
		{
	//     $search = $this->input->post('postal_code');
	
	     $sql = "SELECT * FROM ChurchList";
	
	    $sql_query = $this->db->query($sql);
	
	    if($sql_query->num_rows() > 0){
	
	        foreach($sql_query->result_array() as $row){
					$data[] = $row;
	        }
	        return $data;
	
	        }
	
		}
	
        /**
         * takes a submitted date and event type and returns a list of parishes with
         * matching events
         *
         * @return key pairs|null of fields
         */
        function list_churches($where)
        {
         $data = array();
        $sql = "SELECT * FROM ChurchList ".$where;
        $squery = $this->db->query($sql);

        foreach($squery->result_array() as $row){
				$data[] = $row;
        }
        return $data;

        }
    
        function find_parishes($parishID)
        {
        
        $data = array();
        $sql = "SELECT 
                Church.Church,
                `Church`.`idChurch`,
                Parish.Parish, 
                `Parish`.`idParish`
                FROM Church
                JOIN Parish ON Parish.idParish = Church.Parish_idParish

                Where Church.`Parish_idParish` =".$parishID;
        $squery = $this->db->query($sql);

        foreach($squery->result_array() as $row){
				$data[] = $row;
        }
        return $data;
        
        
        }

        function list_languages_Church(){
        $sql= "SELECT idLanguage, Language, LanguageLocal, LanguageShort FROM Language";
        $squery = $this->db->query($sql);
        return $squery->result_array();
        }

        function list_City_Church()
        {
            $sql= "select idCity, City from City ORDER BY CITY";
            $squery = $this->db->query($sql);
            return $squery->result_array();
        }
		
		function list_dropdown($columnname1, $columname2, $tablename){
			$this->db->select(''.$columnname1.','.$columname2.'');
			$query = $this->db->get($tablename);

			return $query->result_array();
			
		}
        function list_mass()
        {
            //TODO parse request
            //TODO query Parishfinder DB by events
            //TODO return results
        }


        /**
         * takes a submitted date and event type and returns a list of clergy or people
         * matching events
         *
         * @return key pairs|null of fields
         */
        function list_clergy()
        {
            //TODO parse request
            //TODO query Parishfinder DB by events
            //TODO return results
        }
        
        function listaddress_church($cid)
        {
            $sql= "select * from ListAddressByChurch where idChurch = '$cid'";
            $squery = $this->db->query($sql);

            return $squery->result_array();
        }
    
        function listphone_church($cid)
        {
            $sql= "select * from ListPhoneByChurch where idChurch = '$cid'";
            $squery = $this->db->query($sql);

            return $squery->result_array();
        }
    
        function listsocial_church($cid)
        {
            $sql= "select * from ListSocialByChurch where idChurch = '$cid'";
            $squery = $this->db->query($sql);

            return $squery->result_array();
        }
    
        function website_church($cid)
        {
            $sql= "select * from ListWebsiteByChurch where idChurch = '$cid'";
            $squery = $this->db->query($sql);

            return $squery->result_array();
        }
        
        function getChurchName($cid)
        {
	        $sql= "select * from ParishAndChurchID where CID = '$cid'";
            $squery = $this->db->query($sql);
            
            return $squery->result_array();
	        
        }
        
        function clergy_church($Pid)
        {
            $sql= "select * from ListClergyByChurch where idParish = '$Pid'";
            $squery = $this->db->query($sql);

            return $squery->result_array();
        }
        
        function list_eventsType(){
	        $sql= "select idEventType, EventType from EmailType";
            $squery = $this->db->query($sql);
            return $squery->result_array();
	        
        }
        
        function list_events_Church($cid){
        $data = array();
        $sql = "SELECT * FROM churcheventlist where  ACTIVE ='1' AND Church_idChurch = ".$cid;
        $squery = $this->db->query($sql);
        
            foreach($squery->result_array() as $row){
				$data[] = $row;
            }

         return $data;
         
        }
        
        function searchAllParishChurch($searchString)
        {
  			$result = $this->db->query("Select * from ParishAndChurchID where `ParishName` LIKE '%$searchString%' OR `ChurchName` LIKE '%$searchString%'");
  			
  			$data = array();
  			foreach ($result->result_array() as $row)
  			{

	  			foreach ($this->listaddress_church($row['CID']) as $resrow){
				
				$data[]= array("Church"=>$row['ChurchName'], 
					  "Parish"=>$row['ParishName'],
					  "PID"=>$row['PID'],
					  "CID"=>$row['CID'],
					  "Address"=> $resrow['Street1'],
					  "City"=>$resrow['City'],
					  "Province"=>$resrow['Abbreviation'],
					  "PostalCode"=>$resrow['PostalCode']
					  );
				}
					  
  			}

  			return $data;	
        }
        
        function searchAllCity()
        {
  			$result = $this->db->query("Select * from ParishAndChurchID");
  			
  			$data = array();
  			foreach ($result->result_array() as $row)
  			{

	  			foreach ($this->listaddress_church($row['CID']) as $resrow){
				
				$data[]= array("Church"=>$row['ChurchName'], 
					  "Parish"=>$row['ParishName'],
					  "PID"=>$row['PID'],
					  "CID"=>$row['CID'],
					  "Address"=> $resrow['Street1'],
					  "City"=>$resrow['City'],
					  "Province"=>$resrow['Abbreviation'],
					  "PostalCode"=>$resrow['PostalCode']
					  );
				}
					  
  			}

  			return $data;	
        }
        
        function getAllEvents($cid)
        {
	        //call get eventids on churchd id from events db
	        
	        return $this->getEventScheduleFromID($cid);
	        
        }
        
        function getEventScheduleIds($cid)
        {
	        //call get eventids on churchd id from events db
	        //returns array with event schedule IDs
	        $result = $this->db->query("Select EventType_idEventType, `EventSchedule_idEventSchedule`, Active from Event where `Church_idChurch` =".$cid);

		       if (count($result->result_array())>0) 
		       {
			        foreach ($result->result_array() as $row)
		  			{
			  			$data[]= array(
				  			"EventTypeID" => $row['EventType_idEventType'],
				  			"EventSchedule" => $row['EventSchedule_idEventSchedule'],
				  			"Active" => $row['Active']
			  			);
		  			}
		  			
			  			return $data;
		  			
	  			}else{
		  			return false;
	  			}
        }
        
        function getEventScheduleFromID($cid)
        
        {
			if ($this->getEventScheduleIds($cid)){
		        foreach ($this->getEventScheduleIds($cid) as $eachScheduleID){
			        $result = $this->db->query("Select OneTime, MonthlyOn1, MonthlyOn2, MonthlyOn3, MonthlyOn4, MonthlyOn5, MonthlyOnLast, MonthlyOnDate, Weekly, Mon, Tue, Wed, Thu, Fri, Sat, Sun, Holidays, HolidayRecord, StartTime, EndTime from EventSchedule where idEventSchedule =".$eachScheduleID["EventSchedule"]);
		        	foreach ($result->result_array() as $row)
		  			{
			  			$data[]= array(
				  			"EventID" => $eachScheduleID['EventSchedule'],
				  			"Schedule" => $this->schedule($result->result_array()),
				  			"dayOfWeek"=>$this->dayofWeek($result->result_array()),
							"Holidays" => $row['Holidays'],
							"HolidayRecord" => $row['HolidayRecord'],
							"StartTime" => $row['StartTime'],
							"EndTime" => $row['EndTime'],
							"Active" => $eachScheduleID["Active"],
							"idEventType"=>$eachScheduleID['EventTypeID'],
							"EventType" => $this->getEventType($eachScheduleID['EventTypeID'])
			  			);
		  			}
		        }
		        return $data;		        
	        }
        }
        
        function getEventType($eventTypeID)
        {
	        //returns Name of Type of event 
	        $result = $this->db->query("Select EventType from EventType where `idEventType`=".$eventTypeID);
	        
		        foreach ($result->result_array() as $row)
	  			{
			  			return $row['EventType'];
		  			
	  			}
        }
        function dayofWeek($array)
        {
	        foreach($array as $row){
		        
		        if($row['Mon'] == 1)
		        {
			        return 'Monday';
		        }
		        if ($row['Tue'] == 1)
		        {
			        return 'Tuesday';
		        }
		        
		        if ($row['Wed'] == 1)
		        {
			        return 'Wednesday';
		        }
		        
		        if ($row['Thu'] == 1)
		        {
			        return 'Thursday';
		        }
		        
		        if ($row['Fri'] == 1)
		        {
			        return 'Friday';
		        }
		        
		        if ($row['Sat'] == 1)
		        {
			        return 'Saturday';
		        }
		        
		        if ($row['Sun'] == 1)
		        {
			        return 'Sunday';
		        }
	        }
        }
        function schedule($array){
	        foreach($array as $row){
		        if ($row['Weekly'] == 1){
			        return 'Weekly';
		        }
		        if ($row['OneTime'] == 1){
			        return 'OneTime';
		        }
		        if ($row['MonthlyOn1'] == 1){
			        return 'First';
		        }
		        if ($row['MonthlyOn2'] == 1){
			        return 'Second';
		        }
		        if ($row['MonthlyOn3'] == 1){
			        return 'Third';
		        }
		        if ($row['MonthlyOn4'] == 1){
			        return 'Fourth';
		        }
		        if ($row['MonthlyOn5'] == 1){
			        return 'Fifth';
		        }
		        if ($row['MonthlyOnLast'] == 1){
			        return 'Last';
		        }
		        if ($row['MonthlyOnDate'] == 1){
			        return 'MonthlyOnDate';
		        }
		        
	        }
	        
        }
        function updateAddress($idAddress,$idAddressType,$idChurch,$idCountry,$idCity,$idProvince,$Street1,$PostalCode,$Longitude,$Latitude){
	        $data = array('AddressType_idAddressType' => $idAddressType,
	        			 'City_idCity' => $idCity,
	        			 'Province_idProvince' => $idProvince,
	        			 'Country_idCountry' => $idCountry,
	        			 'Street1' => $Street1,
	        			 'PostalCode' => $PostalCode,
	        			 'Longitude' => $Longitude,
	        			 'Latitude' => $Latitude
	        			 );
				
				$where = "idAddress = $idAddress AND Church_idChurch = $idChurch"; 

				$this->db->update('Address', $data, $where);
        }
        function updatePhone($idChurch, $idPhone, $idPhoneType, $AreaCode, $Phone){

	        	$data = array('PhoneType_idPhoneType' => $idPhoneType,
	        	 			  'AreaCode' => $AreaCode,
				 			  'Phone' => $Phone
				 			  );
				
				
				$where = "idPhone = $idPhone AND Church_idChurch = $idChurch"; 

				$this->db->update('Phone', $data, $where);

        }
        function updateWEbsite($idChurch, $idWeb, $idWebType, $Url){
				$data = array('WebType_idWebType' => $idWebType,
	        	 			  'Url' => $Url
				 			  );
				
				
				$where = "idWeb = $idWeb AND Church_idChurch = $idChurch"; 

				$this->db->update('Web', $data, $where);

        }
        function updateEmail($idChurch, $idEmail, $idEmailType, $Email ){
	        	$data = array('EmailType_idEmailType' => $idEmailType,
	        	 			  'Email' => $Email
				 			  );
				
				
				$where = "idEmail = $idEmail AND Church_idChurch = $idChurch"; 

				$this->db->update('Email', $data, $where);
        }
 


}

/* End of file parishfinder_model.php */
/* Location: ./application/models/parishfinder_model.php */
