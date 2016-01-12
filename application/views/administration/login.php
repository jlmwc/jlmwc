<!DOCTYPE html>
<html>
<?php if(isset($this->session->userdata['logged_in'])){ 
  header("location: memberArea");
}?>
<head>
<title>Login </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
	<body>
	    <div class="container">
		    <div class="row">
		                <div class="col-md-2">
								<?php $error_message?>
		                        <?php echo validation_errors(); ?>
								<?php echo form_open('index.php/verifyLogin'); ?>
		                          <fieldset>
		                            <div id="legend">
		                              <legend class="">Login</legend>
		                            </div>
		                            <div class="form-group">
		                              <!-- Username -->
		                              <label c for="username">Username</label>
		                              <div class="controls">
		                                <input type="text" id="username" name="username" placeholder="" class="form-control input-xlarge ">
		                              </div>
		                            </div>
		                            <div class="form-group">
		                              <!-- Password-->
		                              <label for="password">Password</label>
		                              <div class="controls">
		                                <input type="password" id="password" name="password" placeholder="" class="form-control input-xlarge">
		                              </div>
		                            </div>
		                            <div class="form-group">
		                              <!-- Button -->
		                              <div class="controls">
		                                <input name="submit" class="btn btn-success" type="submit" value=" Login ">
		
		                              </div>
		                            </div>
		                          </fieldset>
		                        <?php echo form_close(); ?>
		                </div>
		        </div>
			</div>
	
	</body>

</html>
