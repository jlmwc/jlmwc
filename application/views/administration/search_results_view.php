<h2>Search Results</h2>

<table class="results">
    <tbody>
	        <?php
		        if ($html)
		        {
					for ($i = 0; $i < count($html); $i++)
					{
				        if($html[$i]['Church'] == $html[$i]['Parish'])
				        {
					        echo "<tr>
					        <td>
								<strong>".$html[$i]['Church']."</strong><br>";
					        
				        }else{
					        echo " <td>
						        <strong>".$html[$i]['Parish']."</strong><br>
						        <strong>".$html[$i]['Church']."</strong><br>";
				        }
				        echo $html[$i]['Address']."<br>".
		                	  $html[$i]['City'].",".$html[$i]['Province'];
						?></td>
							<td><a class="button" href="<?php echo base_url(); ?>memberArea/editChurch/<?php echo $html[$i]['CID'] ?>">Edit</a></td>
						</tr>
					<?php
					}
				}else{
					echo "Unable to find results in Parish and Church databases. Please try another search";
				}
	        ?>
    </tbody>
</table>




