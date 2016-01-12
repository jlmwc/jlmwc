<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<title>Parishfinder -- Calgary Catholic Diocese</title>

    <!--scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- styles -->
	<link href='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.css' rel='stylesheet' />
	<link href="/styles/main.css" rel="stylesheet" />

	<!--[if lt IE 9]>
    <script src="scripts/html5shiv.min.js"></script>
	<![endif]-->

</head>
<body>
	<div id="container">

		<nav class="find">
			
			<a class="search"></a>
			<a class="list"></a>
			<a class="map"></a>
            <a class="detail"></a>
            
		</nav>

		<section id="mapbox">
			<header>
				<h1>Parishfinder</h1>
				<h3>Roman Catholic Diocese of Calgary</h3>
			</header>
			<div id="map" style="position:absolute;"></div>
		</section>


		<section id="find">
			<div class="wrapper">
				<header>
					<h1>Search for a Parish</h1>
				</header>

				<!-- search by postal code -->
				<section>
					<header>
						<h2>Locate a Postal Code</h2>
					</header>
					<?php

						$postalCodeText = array(
							'name'	=> 'postalCodeText',
							'id'	=> 'postalCodeText'
						);
						$formPostalSubmit = array(
							'name'	=> 'postalCodeSubmit',
							'id'	=> 'postalCodeSubmit',
							'value'	=> 'Show Postal Code'
						);
						echo validation_errors();
						echo form_label('Postal Code', 'postalCodeLabel');
						echo form_input($postalCodeText);
                        echo '<p><span class = "postalCodeError"></span></p>';
						echo '<div class="submit">';
						echo form_submit($formPostalSubmit);
						echo '</div>';
					?>
				</section>
				<!-- search for churches -->
				<section>
					<header>
						<h2>Find by Parish Name</h2>
					</header>
					<?php
						$data = array(
							'name'	=> 'churchNameField',
							'id'	=> 'churchNameField'
						);
						
						echo form_label('Church Name', 'churchNameLabel');
                        
						echo form_input($data);

                        
					?>
				</section>
				
				<!-- filter by city -->
				<section>
					<header>
						<h2>Search by Municipality</h2>
					</header>
					<label for="cityDropdown">City</label>
					<select id="cityDropdown">
                        <option value = ""> ALL cities </option></select>
                <?php
                    $formParishSubmit = array(
							'name'	=> 'findParish',
							'id'	=> 'findParish',
							'value'	=> 'Search'
						);
                        echo '<div class="submit">';
						echo form_submit($formParishSubmit);
						echo '</div>';
                ?>
				</section>
			</div>
		</section>


		<section id="list">
			<div class="wrapper">
				<header>
					<h1>Results</h1>
				</header>
				<div id="searchResults"></div>
			</div>
		</section>


		<section id="detail">
			<div class="wrapper">
				<header>
					<h1>Parish Details</h1>
				</header>
				<div id="parishDetails"></div>
			</div>
		</section>

		<div class="loading hide"><p>LOADING...</p></div>

    </div>

	<!-- scripts -->
	<script src='https://api.mapbox.com/mapbox.js/v2.2.2/mapbox.js'></script>
	<script src="/scripts/main.js"></script>

	<!-- /scripts -->

</body>

</html>
