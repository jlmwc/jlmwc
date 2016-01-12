<section>
	<form id="churchPhone"> 
		<?
			echo "<form id=\"churchPhone\">";
			foreach ($churchPhone[0]['phoneDetails'] as $row)
				{	
					echo "<label for=\"phoneType\">Phone Type:</label>";
				  	$options = array();
						for ($i=0; $i<=count($phone); $i++)
						{
							if (isset($phone[$i]))
							{
								$options[$phone[$i]['idPhoneType']] = $phone[$i]['PhoneType'];
	    					}
	    				}
					echo form_dropdown('PhoneType', $options, $row['idPhoneType']);
					echo "<label for=\"phone\">Phone number:</label>";
					echo "<input type=\"text\" id=\"areaCode\" name=\"areaCode\" id=\"areaCode\" maxlength=\"3\"value='".$row['AreaCode']."'>";
					echo "<input type=\"text\" id=\"phoneNumber\" name=\"phoneNumber\" id=\"phoneNumber\" maxlength=\"7\"value='".$row['Phone']."'>";
					
			  	}
			echo "</form>";  	
		?>
</section>
