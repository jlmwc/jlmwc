<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ParishFinder Admin - Search Page</title>
        <link rel="stylesheet" href="/styles/admin.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        
    </head>
    <body>
        <header>
            <div class="logo"></div>
            <h1>ParishFinder Admin</h1>
            <h3>Roman Catholic Diocese of Calgary</h3>
        </header>
       
        
        <section class="searchPanels">
             <p>Welcome, <?php echo $username; 
	             			
             ?></p>
              <a href="memberArea/logout">Logout</a>
              
            <h1>Search</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.</p>
            
            <div class="module">
	            <?php
		            $formattributes = array('id' => 'byParishName');
                	echo form_open('memberArea/search', $formattributes);
					echo form_label('Find a Parish by Name', 'searchParishName');
                    $data = array(
						'name'        => 'searchParishName',
						'id'          => 'searchParishName',
						'placeholder' => 'Parish Name'
						);
					echo form_input($data);
				?>
                    <input type="submit" id ="SearchParish" name ="SearchParish" value="Search" />
                <?php echo form_close();
                ?>
                
            </div>
            
            <div class="module">
				<?php 
					$formattributes = array('id' => 'byMunicipality');
					echo form_open('memberArea/search', $formattributes);
					echo form_label('City');

					$options = array();
					for ($i=0; $i<=count($selected); $i++)
					{
						if (isset($selected[$i]))
						{
							$options[$selected[$i]['idCity']] = $selected[$i]['City'];
    					}
    				}

					echo form_multiselect('City[]', $options, '', 'id="City"');
				?>
				<input type="submit" id = "SearchCity" name = "SearchCity" value="Search" />
				<?php
					echo form_close();
				?>                
            </div>
        </section>
        
        <article id= "searchResults">
	    </article>
	    
	<script type="text/javascript">
		$(function() {
	        $('#byParishName').submit(function(){
		       $( '#searchResults' ).empty();
		       
		       $.ajax({
			     url  : "<?php echo site_url('memberArea/search'); ?>",
			     type : 'POST',
			     data : 'search='+$("#searchParishName").val(),
			     success: function (msg){
				   $( '#searchResults' ).html( msg );
			     }
		       });
 		       return false;
	        });
	        
	        $('#byMunicipality').submit(function(){
		        $( '#searchResults' ).empty();
		        var citySelected = []; 
				$('#City :selected').each(function(i, selected){ 
				citySelected[i] = $(selected).text(); 

				});
				
				$.ajax({
			     url  : "<?php echo site_url('memberArea/searchCity'); ?>",
			     type : 'POST',
			     data : {citySelected : citySelected},
			     success: function (msg){
				  
				   $( '#searchResults' ).html( msg );
			     }
			     });
			     return false;						        
	        
	        });
	    });
        </script>
    
<!-- 	<script src="/scripts/memberArea.js"></script> -->
    </body>
</html>