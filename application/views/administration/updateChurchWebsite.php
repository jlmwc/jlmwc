<section>
		<form id="churchWebsite" > 
		<?

			foreach ($churchWebsite[0]['websiteDetails'] as $row)
				{
					  echo "<label for=\"webType\">Web Type:</label>";
					  	$options = array();
							for ($i=0; $i<=count($web); $i++)
							{
								if (isset($web[$i]))
								{
									$options[$web[$i]['idWebType']] = $web[$i]['WebType'];
		    					}
		    				}
					  echo form_dropdown('webType', $options, '1');
					  
					  
					  echo "<label for=\"website\">Website:</label>";
					  echo "<input type=\"text\" name=\"website\" id=\"Website\"value='".$row['Url']."'>";
					  
					  echo "<label for=\"webType\">Email Type:</label>";
					  	$options = array();
							for ($i=0; $i<=count($email); $i++)
							{
								if (isset($email[$i]))
								{
									$options[$email[$i]['idEmailType']] = $email[$i]['EmailType'];
		    					}
		    				}
					  echo form_dropdown('emailType', $options, $row['idEmailType']);
					  			  
					  echo "<label for=\"email\">Email:</label>";
					  echo "<input type=\"text\" name=\"email\" id=\"email\"value='".$row['Email']."'>";
				}
			?>
		</form > 	
</section>