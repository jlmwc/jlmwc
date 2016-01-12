<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ParishFinder Admin - Search Page</title>
    <link rel="stylesheet" href="http://pf.methodworks.ca/styles/main.css">
    <link rel="stylesheet" href="/styles/admin.css">
	<link rel="stylesheet" href="/styles/jquery-ui.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
   
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
</head>

<body>
    <header>
        <div class="logo"></div>
        <h1>ParishFinder Admin</h1>
        <h3>Roman Catholic Diocese of Calgary</h3>
    </header>
	
	<section class="details">
	<?php
// 		print_r($churchDetails);
	foreach($churchDetails[0]['ChurchInfo'] as $row){
		echo "<h2>".$row['ParishName']."</h2>";
		echo "<h3>".$row['ChurchName']."</h3>";
	}	

	if (count($churchDetails[0]['ChurchInfo']) > 0)
	{
		echo '<dl class="addresses">';
	
		foreach($churchDetails[1]['addressDetails']as $row){
			echo "<dt>".$row['AddressType']." Address </dt>";
			echo "<dd>".$row['Street1']."<br>";
			echo $row['City'].",".$row['Abbreviation']." ".$row['PostalCode']."</dd>";
			echo "<button id=\"editChurchaddress\" data-Add='".$row['idAddress']."' data-id='".$churchDetails[0]['ChurchInfo'][0]['CID']."'>Edit</button>";
		}
		echo "</dl>";
	}
	
	if (count($churchDetails[2]['phoneDetails'] > 0 ))
	{
		echo '<dl class="phones">';
		
		foreach($churchDetails[2]['phoneDetails']as $row){
			echo "<dt>".$row['PhoneType']." </dt>";
			echo "<dd>".$row['AreaCode']."-".$row['Phone']."</dd>";
		}	
			echo "<button id=\"editChurchphone\" data-Phone='".$churchDetails[2]['phoneDetails'][0]['idPhone']."' data-id='".$churchDetails[0]['ChurchInfo'][0]['CID']."'>Edit</a></button>";
		echo "</dl>";
	}

	if (count($churchDetails[3]['socialDetails']) >0)
	{
	}else{
		echo "";
	}
	
	if ($churchDetails[4]['websiteDetails'][0]['Email'] !== NULL && $churchDetails[4]['websiteDetails'][0]['Url'] !== NULL)
	{
		echo '<dl class="online">';
		
		foreach($churchDetails[4]['websiteDetails']as $row){
			echo "<dt>".$row['WebType']." </dt>";
			echo "<dd>".$row['Url']."</dd>";
			echo "<dt> Email </dt>";
			echo "<dd>".$row['Email']."</dd>";
			echo "<button id=\"editChurchwebsite\" data-email='".$row['idEmail']."' data-Web='".$row['idWeb']."' data-id='".$churchDetails[0]['ChurchInfo'][0]['CID']."'>Edit</button>";
		}	
// 		<a href=".base_url()."".$churchDetails[0]['ChurchInfo'][0]['CID'].">

		echo "</dl>";
	}else{
		echo "";
	}
	?>
	</section>
<!--
	<button><a href="<?php echo base_url(); ?>CRUDChurchDetail/updateChurchInfo/<?php echo $churchDetails[0]['ChurchInfo'][0]['CID'] ?>">Update Information</a></button>
	<button><a href="<?php echo base_url(); ?>CRUDChurchDetail/addChurchInfo">Add Information</a></button>
-->

    <section class="events">
        <h2>Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Type</th>
                    <th>Schedule</th>
                    <th>Time</th>
                    <th>Active</th>
                </tr>
            </thead>
            <?php
			        
            if ($churchDetails[5]['eventsDetails'])
				{
					echo '<tbody>';
					
					foreach($churchDetails[5]['eventsDetails']as $row){
						echo "<tr>";
						echo "<td>".$row['dayOfWeek']."</td>";
						echo "<td>".$row['EventType']."</td>";
						if ($row['Schedule'] == 'Weekly')
						{
							echo "<td>".$row['Schedule']."</td>";	
						}else{
							echo "<td>".$row['Schedule']." ".$row['dayOfWeek']."</td>";
						}
						echo "<td>".$row['StartTime']."-".$row['EndTime']."</td>";
						if($row['Active']==1)
						{
							echo "<td> YES </td>";
						}else
						{
							echo "<td> NO </td>";
						}

						echo "<td><button id=\"currEvents\" data-id=".$churchDetails[0]['ChurchInfo'][0]['CID']." data-eventid=".$row['EventID'].">Edit</button></td>";
					}	
					
					echo "</tr>";
				}else{
					echo "No registered events";
				}	            
            ?>
            </tbody>
        </table>
        <a class = "button" href="<?php echo base_url(); ?>CRUDChurchDetail/addChurchEvents">Add Event</a>   
    </section>
    <section>
	    <div id="editDialog"></div>	    
	</section>
	   <section>
	    <div id="confirmDialog"></div>
		    
	    </section>
		<section>
	    <div id="thankYou"></div>
		    
	    </section>
    
    <script type="text/javascript">	
    	$(function() {
	    	var editDialog;
	    	userValues = {}
	    	
	        $('#editChurchaddress, #editChurchphone, #editChurchwebsite, #currEvents').click(function(){
 		       var cid  =  $(this).data('id');
 		       userValues['cid'] = cid;
 		       userValues['idAddress'] = $(this).data('add');
 		       userValues['idPhone'] = $(this).data('phone');
 		       userValues['idWeb'] = $(this).data('web');
 		       userValues['idEmail']=$(this).data('email');
 		       
 		       var eid  =  $(this).data('eventid');
 			   
 			   if($(this).attr('id') === 'editChurchaddress'){
	 			   
		 			$.ajax({
						url  : "<? echo site_url('CRUDChurchDetail/updateChurchaddress'); ?>",
						type : 'POST',
						data : {cid : cid},
						success: function (msg){
							
						$( '#editDialog' ).empty();
							editDialogbox(msg);
							editDialog.dialog( "open" );

						}
			       });
 			   }else if($(this).attr('id') === 'editChurchphone'){
	 			   
					$.ajax({
						url  : "<? echo site_url('CRUDChurchDetail/updateChurchphone'); ?>",
						type : 'POST',
						data : {cid : cid, eid:eid},
						success: function (msg)
						{

							$( '#editDialog' ).empty();
							editDialogbox(msg);
							editDialog.dialog( "open" );

						}
		       		});
	 			   
 			   }else if($(this).attr('id') === 'editChurchwebsite'){
	 			   
					$.ajax({
		 			  	url  : "<? echo site_url('CRUDChurchDetail/updateChurchwebsite'); ?>",
		 			  	type : 'POST',
		 			  	data : {cid : cid},
		 			  	success: function (msg)
		 			  	{
						 $( '#editDialog' ).empty();
							editDialogbox(msg);
							editDialog.dialog( "open" );
		 			  	

				     	}
		       		});

 			   }else if($(this).attr('id') === 'currEvents'){
	 			   userValues['eid'] = eid;
	 			   $.ajax({
		 			   url  : "<? echo site_url('CRUDChurchDetail/updateChurchEvents'); ?>",
		 			  	type : 'POST',
		 			  	data : {cid: cid, eid : eid},
		 			  	success: function (msg)
		 			  	{
		 			  	$( '#editDialog' ).empty();
							editDialogbox(msg);
							editDialog.dialog( "open" );

				     	}
	 			   });
	 			   
 			   }
  		       return false;
	        });
	        
	        function confirm(){
				
 				console.log("Confirmed moving on" );
				console.log(userValues);
				
				/*
				*TODO: send uservalues to ajax controller
				*/
				$.ajax({
		 			   url  : "<? echo site_url('update'); ?>",
		 			  	type : 'GET',
		 			  	data : userValues,
		 			  	success: function ()
		 			  	{
		 			  		confirmDialog.dialog( "close" );
		 			  		editDialog.dialog( "close" );
		 			  		
		 			  		$( "#thankYou" ).empty();
		 			  		$('#thankYou').append('<p>Thank you for your confirmation. Please be patient as the page loads with your changes.</p>');
		 			  		thankyouDialog.dialog( "open" );
		 			  		userValues = {};

				     	},
				     	error: function(XMLHttpRequest, textStatus, errorThrown) { 
				        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
				    	}

	 			   });
				
				
				thankyouDialog = $( "#thankYou" ).dialog({
					modal: true,
					title:"Sending Confirmation...",
						buttons: {
							Ok: function() {
							$( this ).dialog( "close" );
							location.reload();
        				}
      				}
    			});
				
		        
	        }
	        
	        function editDialogbox(msg){
		        
		        $( '#editDialog' ).append( msg );

				editDialog = $( "#editDialog" ).dialog({
						
							height: 600,
							width: 350,
							modal: true,
							title: 'Edit Area',
							buttons: {
							"Update" : valid,
								Cancel: function() {
								editDialog.dialog( "close" );
								}
							},
						close: function() {
							editDialog.dialog( "close" );
							}
			
				});
				
	        }
	       
			function valid(){
				$( "#confirmDialog" ).empty();
				$( "#confirmDialog" ).append(getValues());
					confirmDialog = $( "#confirmDialog" ).dialog({
								
							height: 600,
							width: 350,
							modal: true,
							title: 'Confirmation Area',
						buttons: {
							"Confirm" : confirm,
								"Back": function() {
								confirmDialog.dialog( "close" );
								}
							},
						close: function() {
							confirmDialog.dialog( "close" );
							}
						});
		        
		        confirmDialog.dialog( "open" );
		        
			}
			
			function getValues(){
				var html = "";
				var address ="";
				var phone ="";
				var web ="";
				
				/*
				*TODO : concise Code get values with value[i].type and make functions
				*TODO : collect all values into objects ans send them to AJAX codeigniter Controller Update
				*TODO : Controller UPDATE information to DB
				*/
					
					$('#churchAddress').each(function(key, value) { 
						for (var i=0; i<value.length; i++)
 						{
	 						if (value[i].name === 'addressType'){
		 						
		 						address += " Address Type "+value[i].options[value[i].selectedIndex].text+"<br>";
		 						userValues['AddressType'] = value[i].value;
		 						
		 					}else if (value[i].name ==='Street1'){
			 				
			 					address += " Street : "+value[i].value+"<br>";
			 					userValues['Street1'] = value[i].value;
		 					
		 					}else if (value[i].name ==='city'){
			 				
			 					address += " City : "+value[i].options[value[i].selectedIndex].text+"<br>";
			 					userValues['idCity'] = value[i].value;
		 					
		 					}else if (value[i].name ==='Abbreviation'){
			 				
			 					address +=" Province : "+value[i].options[value[i].selectedIndex].text+"<br>";
			 					userValues['idProvince'] = value[i].value;
		 					
		 					}else if (value[i].name ==='postalCode'){
			 					address +=" Postal Code : "+value[i].value+"<br>";
			 					userValues['PostalCode'] = value[i].value;
		 					}else if (value[i].name ==='latitude'){
			 					address +=" Postal Code : "+value[i].value+"<br>";
			 					userValues['Latitude'] = value[i].value;
		 					}else if (value[i].name ==='longitude'){
			 					address +=" Postal Code : "+value[i].value+"<br>";
			 					userValues['Longitude'] = value[i].value;
		 					}
		 					
 						}
					});
					
					$('#churchPhone').each(function(key, value) { 
 						
 						for (var i=0; i<value.length; i++)
 						{
	 						
	 						if (value[i].name === 'PhoneType'){
		 					phone+= " Phone Type :"+value[i].options[value[i].selectedIndex].text+"<br>";
		 					userValues['idPhoneType'] = value[i].value;	
		 					}else if (value[i].name ==='areaCode'){			 					
			 					phone += " Area Code : "+value[i].value+"<br>";
		 					userValues['AreaCode'] = value[i].value;			 					
		 					}else if (value[i].name ==='phoneNumber'){
			 					phone += " Phone : "+value[i].value+"<br>";
			 					userValues['Phone'] = value[i].value;	
			 				}else{
			 					phone+="";
		 					}
 						}	
					});
					
					$('#churchWebsite').each(function(key, value) {
						for (var i=0; i<value.length; i++)
 						{
	 						if (value[i].name === 'webType'){
		 						
			 					web += "WebsiteType:"+value[i].options[value[i].selectedIndex].text+"<br>";	
			 					userValues['WebsiteType'] = value[i].value;	
		 					}else if (value[i].name ==='website'){
				 				web += "Website :"+value[i].value+"<br>";
				 				userValues['Url'] = value[i].value;
		 					}else if (value[i].name ==='emailType'){
			 					web += " Email : "+value[i].options[value[i].selectedIndex].text+"<br>";
			 					userValues['EmailType'] = value[i].value;	
		 					}else if (value[i].name ==='email'){
			 					web += " Email : "+value[i].value+"<br>";
			 					userValues['Email'] = value[i].value;	
		 					}else{
			 					web+="";
		 					}
 						}
					});
				
					return html = address + phone + web ;
				
			}								
	   });
    </script>

</body>

</html>
