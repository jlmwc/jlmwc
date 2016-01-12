<section>
	
	<form id="churchAddress" > 
		
	<?php 
		foreach ($churchAddress[0]['addressDetails'] as $row)
		{
			echo "<label for=\"addressType\">Address Type:</label>"; 
			$options = array();
			for ($i=0; $i<=count($addressType); $i++)
			{
				if (isset($addressType[$i]))
				{
					$options[$addressType[$i]['idAddressType']] = $addressType[$i]['AddressType'];
				}
			}
			
			echo form_dropdown('addressType', $options, $row['idAddressType']);
		
			echo '<label for="Street">Street:</label>';
			echo "<input type=\"text\" name=\"Street1\"  id=\"Street1\" value='".$row['Street1']."'>";
			
			echo ' <label for="City">City:</label>';
		  
	  		$options = array();
			for ($i=0; $i<=count($city); $i++)
			{
				if (isset($city[$i]))
				{
					$options[$city[$i]['idCity']] = $city[$i]['City'];
				}
			}

			echo form_dropdown('city', $options, $row['idCity']);
			echo "<label for=\"Province\">Province:</label>";
	  
		  	$options = array();
				for ($i=0; $i<=count($province); $i++)
				{
					if (isset($province[$i]))
					{
						$options[$province[$i]['idProvince']] = $province[$i]['Abbreviation'];
					}
				}
			echo form_dropdown('Abbreviation', $options, $row['idProvince']);
	  
			echo "<label for=\"postalCode\">Postal Code:</label>";
			echo "<input type=\"text\" name=\"postalCode\" id=\"PostalCode\"value='".$row['PostalCode']."'>";
			
			echo "<label for=\"latitude\">Latitude:</label>";
			echo "<input type=\"text\" placeholder =\"Optional\" name=\"latitude\" id=\"latitude\"value='".$row['Latitude']."'>";
			
			echo "<label for=\"longitude\">Longitude:</label>";
			echo "<input type=\"text\" placeholder =\"Optional\" name=\"longitude\" id=\"longitude\"value='".$row['Longitude']."'>";
			
		}
	?>
	<p> Trouble finding longitude and latitude visit <a href ="http://www.latlong.net/" target="_blank"> Click Here </a> </p>
	</form>
</section>
    