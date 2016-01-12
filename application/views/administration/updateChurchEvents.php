    <section>
	    <form>
			<fieldset>
			<?
 			print_r($EventID);	print_r($cid);
 			
            echo form_label('Type of Events ', 'eventType');

            $eventTypeOptions = array();
			for ($i=0; $i<=count($eventType); $i++)
			{
				if (isset($eventType[$i]))
				{
					$eventTypeOptions[$eventType[$i]['idEventType']] = $eventType[$i]['EventType'];
				}
			}
			?>
			
			<div class= "OneTime">
			
			<?php
				
				echo form_dropdown('eventType', $eventTypeOptions, $idEventType);
		
		        echo form_label('Day of the Week', 'daysOfWeek');	
				//label needed
				$options = array(
		              'Monday'   => 'Monday',
		              'Tuesday'   => 'Tuesday',
		              'Wednesday'   => 'Wednesday',
		              'Thursday' => 'Thursday',
		              'Friday'   => 'Friday',
		              'Saturday'   => 'Saturday',
		              'Sunday'   => 'Sunday'
		            );                
		        echo form_dropdown('daysOfWeek', $options, $dayOfWeek);
		        
		        echo form_label('One Time', 'oneTime');
		        $data = array(
				    'name'        => 'Schedule',
				    'id'          => 'oneTime',
				    'value'       => 'accept',
				    'checked'     => TRUE,
				    'style'       => 'margin:10px',
				    );
				
				echo form_radio($data);
		        
		        $data = array(
                      'name'=> 'check_date',
                      'id' => 'datepicker',
                      'placeholder' => 'Enter a Date',
                    );
                echo form_input($data);
                
                
                $data = array(
                      'name'=> 'check_date',
                      'id' => 'from',
                      'placeholder' => 'Start Date',
                    );
                echo form_input($data);
                $data = array(
                      'name'=> 'check_date',
                      'id' => 'to',
                      'placeholder' => 'End Date',
                    );
                echo form_input($data);
		        
		        echo form_label('Active', 'active');
				$data = array(
					'name'        => 'active',
					'id'          => 'active',
					'value'       => 'active',
					'checked'     => $Active,
					'style'       => 'margin:10px',
					);

				echo form_checkbox($data);
		        
		        
				/*TODO 
					date start date = end date yyyy-mm-dd
					start time
					end time
					active?YN
				*/
  
			?>
				
			</div>	
			
			<div class="Recurring">
				<?php
				/*TODO
					day of the week 
					frequency
					start date
					end date
					start time
					end time
					active?YN
				*/
					
				?>
			</div>
				
				
				
				
<!--
		<?php
		

			foreach($events as $eventdata){

			if ($eid == $eventdata['EventID']){
											
			
            //label needed
            
            

            	$eventTypeOptions = array( $eventType['idEventType'] => $eventType['EventType']);
            

            
            print_r($eventTypeOptions);
            echo form_dropdown('eventType', $eventTypeOptions, $eventdata['EventType']);
				
			$start = "00:00";
			$end = "24:00";	
			$tStart = strtotime($start);
			$tEnd = strtotime($end);
			$tNow = $tStart;
			echo form_label('Start Time', 'startTime');	
			
			echo "<select name ='startTime' id='startTime'>";

					while($tNow < $tEnd)
					{
						
						if (date("H:i:s",$tNow) == $eventdata['StartTime']){
						echo "<option selected = \"true\" value=".$tNow." >".date("H:i:s",$tNow)."</option>";	

						}else{
							echo "<option value=".$tNow.">".date("H:i:s",$tNow)."</option>";
						}
						$tNow = strtotime('+15 minutes',$tNow);
					}
			echo "</select>"; 


			$start = "00:00";
			$end = "24:00";	
			$tStart = strtotime($start);
			$tEnd = strtotime($end);
			$tNow = $tStart;
			
			echo form_label('End Time', 'endTime');						
			echo "<select name ='endTime' id='endTime'>";
					while($tNow < $tEnd)
					{
						if (date("H:i:s",$tNow) == $eventdata['EndTime']){
						echo "<option selected = \"true\" value=".$tNow." >".date("H:i:s",$tNow)."</option>";	

						}else{
							echo "<option value=".$tNow.">".date("H:i:s",$tNow)."</option>";
						}
						$tNow = strtotime('+15 minutes',$tNow);
					}
			echo "</select>"; 
			

				echo form_label('Frequency', 'frequency');
				$options = array(
                  'OneTime'     => 'One Time',
                  'First'  => 'First of the Month',
                  'Second'  => 'Second of the Month',
                  'Third'  => 'Third of the Month',
                  'Fourth'  => 'Fourth of the Month',
                  'Fifth'  => 'Fifth of the Month',
                  'Last'  => 'Last of the Month',
                  'Weekly' =>'Weekly'
                );                
				echo form_dropdown('frequency', $options,$eventdata['Schedule']);
				


				}
				
			}
			
		?>
-->
		  
			</fieldset>
		</form>
	    
    </section>
    <script>
$(function() {
	$( "#datepicker" ).datepicker();
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
});
</script>