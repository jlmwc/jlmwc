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
</head>

<body>
    <header>
        <div class="logo"></div>
        <h1>ParishFinder Admin</h1>
        <h3>Roman Catholic Diocese of Calgary</h3>
    </header>
    <section>
	    <form > 
			<fieldset>
			  <label for="addresstype">Address Type:</label>
			  <?php 

				$options = array();
					for ($i=0; $i<=count($addressType); $i++)
					{
						if (isset($addressType[$i]))
						{
							$options[$addressType[$i]['idAddressType']] = $addressType[$i]['AddressType'];
    					}
    				}
                echo form_dropdown('addressType', $options);
                ?>  
			  <label for="Street">Street:</label>
			  <input type="text" name="Street1" id="Street1">
			  
			  <label for="City">City:</label>
			  <?php 

			  	$options = array();
					for ($i=0; $i<=count($city); $i++)
					{
						if (isset($city[$i]))
						{
							$options[$city[$i]['idCity']] = $city[$i]['City'];
    					}
    				}
			  echo form_dropdown('city', $options);
			  ?>
			  
			  <label for="Province">Province:</label>
			  <?php 
			  	$options = array();
					for ($i=0; $i<=count($province); $i++)
					{
						if (isset($province[$i]))
						{
							$options[$province[$i]['idProvince']] = $province[$i]['Abbreviation'];
    					}
    				}
			  echo form_dropdown('Abbreviation', $options);
			  ?>
			  <label for="postalCode">Postal Code:</label>
			  <input type="text" name="postalCode" id="PostalCode">
			</fieldset>

			<fieldset>
			  <label for="phoneType">Phone Type:</label>
			  <?php 
			  	$options = array();
					for ($i=0; $i<=count($phone); $i++)
					{
						if (isset($phone[$i]))
						{
							$options[$phone[$i]['idPhoneType']] = $phone[$i]['PhoneType'];
    					}
    				}
			  echo form_dropdown('phonetype', $options);
			  ?>
			  
			  <label for="phone">Phone number:</label>
			  <input type="text" name="areaCode" id="areaCode" maxlength="3">
			  <input type="text" name="phoneNumber" id="phoneNumber" maxlength="7">
			</fieldset>
			<fieldset>
			  <label for="webType">Web Type:</label>
			  <?php 
			  	$options = array();
					for ($i=0; $i<=count($web); $i++)
					{
						if (isset($web[$i]))
						{
							$options[$web[$i]['idWebType']] = $web[$i]['WebType'];
    					}
    				}
			  echo form_dropdown('webType', $options);
			  ?>
			  
			  <label for="website">Website:</label>
			  <input type="text" name="website" id="Website">
			  			  
			  <label for="email">Email:</label>
			  <input type="text" name="email" id="email">
			</fieldset>
			<input type="submit">
		</form>
	    
    </section>
    </body>

</html>
