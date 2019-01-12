<?php 
print '
	<script>
		function swapVisibility() {
			var passwordInput = document.getElementById("password");
			var passwordRetypeInput = document.getElementById("passwordretype");
			if (passwordInput.type == "password") {
				passwordInput.type = "text";
				passwordRetypeInput.type = "text";
			} else {
				passwordInput.type = "password";
				passwordRetypeInput.type = "password";
			}
		}
	</script>
	';
	
	function randomPassword() {
		$alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$pass = '';
		for ($i = 0; $i < 8; $i++) {
			$letter = rand(0, mb_strlen($alpha) - 1);
			$pass .= mb_substr($alpha, $letter, 1);
		}
		return $pass;
	}
	
	
	$fillUsername = (!isset($_POST['username']) ? "" : $_POST['username']);
	$fillPassword = (!isset($_POST['password']) ? "" : $_POST['password']);
	$fillPasswordretype = (!isset($_POST['passwordretype']) ? "" : $_POST['passwordretype']);
	$fillFirstname = (!isset($_POST['firstname']) ? "" : $_POST['firstname']);
	$fillLastname = (!isset($_POST['lastname']) ? "" : $_POST['lastname']);
	$fillEmail = (!isset($_POST['email']) ? "" : $_POST['email']);
	$fillCountry = (!isset($_POST['country']) ? "" : $_POST['country']);
	$fillCity = (!isset($_POST['city']) ? "" : $_POST['city']);
	$fillStreetaddress = (!isset($_POST['streetaddress']) ? "" : $_POST['streetaddress']);
	$fillDateofbirth = (!isset($_POST['dateofbirth']) ? "" : $_POST['dateofbirth']);
	
	
	function getArrayOfUserNames($MySQL, $like) {
		$query = "SELECT username FROM users WHERE username LIKE '".$like."%'";
		$sql = mysqli_query($MySQL, $query);
		$usrNames = array();
		while($row = mysqli_fetch_array($sql)) {
			array_push($usrNames, $row['username']);
		}
		return $usrNames;
	}
	
	if(isset($_POST['usernameGenerator'])){
		# kreiraj username koji počinje s prvim slovom imena i prezimenom
		if ($fillFirstname != "" && $fillLastname != "") {
			$newPrefix = strtolower(mb_substr($fillFirstname, 0, 1).$fillLastname);
		}
		# Dohvati iz baze sve podatke koji započinju s generiranim stringom (nije case sensitive)
		$usersInDB = getArrayOfUserNames($MySQL, $newPrefix);
		if(in_array($newPrefix, $usersInDB)){
			$i = 0;
			do {
				$i++;
				$fillUsername = $newPrefix.$i;
			} while (in_array($fillUsername, $usersInDB));
		} else {
			$fillUsername = $newPrefix;
		}
	}
	
	if(isset($_POST['passwordGenerator'])){
		# Ovdje kreiraj logiku za izradu passworda
		$newPass = randomPassword();
		# postavi $fillPassword na kreirano
		$fillPassword = $newPass;
		# postavi $fillPasswordretype na kreirano
		$fillPasswordretype = $newPass;
	}
	
	
	if(isset($_POST['submitData'])){
		
		if ( $_POST['password'] != $_POST['passwordretype'] ) {
			$message = "Passwords do not match. Please retype!";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}  else {
		
			# provjeri da li taj user već postoji
			$query  = "SELECT * FROM users WHERE username='" . $_POST['username'] . "' ";
			$query .= "OR email='" . $_POST['email'] . "'";
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			# ako već postoji, izbaci upozorenje
			if ($row['username'] != ''){
				$message = "User with this email or username already exist!";
				echo "<script type='text/javascript'>alert('$message');</script>";
			} else {
				# ako ne postoji ubaci podatke u bazu
				$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
				
				$query  = "INSERT INTO users (firstname, lastname, email, countrycode, city, streetaddress, dateofbirth, username, password, role )";
				$query .= " VALUES ('";
				$query .= $_POST['firstname'] . "', '"; 
				$query .= $_POST['lastname'] . "', '";
				$query .= $_POST['email'] . "', '";
				$query .= $_POST['country'] . "', '";
				$query .= $_POST['city'] . "', '";
				$query .= $_POST['streetaddress'] . "', '";
				$query .= $_POST['dateofbirth'] . "', '";
				$query .= strtolower($_POST['username']) . "', '";
				$query .= $pass_hash . "', '";
				$query .= "Unconfirmed')";
					
				$result = @mysqli_query($MySQL, $query);
				
				# izbaci upozorenje ako nije upisano, a ako je preusmjeri na stranicu s podacima
				if(!$result){
					$message = "Database error, try with different data";
					echo "<script type='text/javascript'>alert('$message');</script>";
				} else {
					$_SESSION['fillUsername'] = $fillUsername;
					$_SESSION['fillPassword'] = $fillPassword;
					$_SESSION['fillFirstname'] = $fillFirstname;
					$_SESSION['fillLastname'] = $fillLastname;
					$_SESSION['fillEmail'] = $fillEmail;
					$_SESSION['fillCountry'] = $fillCountry;
					$_SESSION['fillCity'] = $fillCity;
					$_SESSION['fillStreetaddress'] = $fillStreetaddress;
					$_SESSION['fillDateofbirth'] = $fillDateofbirth;
					header("Location: index.php?menu=8");
				}
			}
		}
	}
	
	print '
	
	<form action="index.php?menu=7" id="contact_form" name="contact_form" method="POST">
		<h1>Registration form
		<button type="submit" name="passwordGenerator" formnovalidate>Auto generate password</button>
		<button type="submit" name="usernameGenerator" formnovalidate>Auto generate username</button>
		</h1>
		<div id="registration">
			Fill registration form with user data:
			<hr/>
			<label for="username">User name *</label>
			<input type="text" id="username" name="username" placeholder="Enter your user name" required value="'.$fillUsername.'">
			
			<label for="password">Enter password *</label>
			<input type="password" id="password" name="password" placeholder="Enter password" required value="'.$fillPassword.'">
			
			<label for="passwordretype">Retype your password *</label>
			<input type="password" id="passwordretype" name="passwordretype" placeholder="Retype your password" required value="'.$fillPasswordretype.'">
			<br />
			
			<input type="checkbox" onclick="swapVisibility()">Show Password
			
			<br /><br />
			
			Contact information:
			<hr />
			
			<label for="firstname">First name *</label>
			<input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required value="'.$fillFirstname.'">

			<label for="lastname">Last name *</label>
			<input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required value="'.$fillLastname.'">
			
			<label for="email">E-mail address *</label>
			<input type="email" id="email" name="email" placeholder="Enter your e-mail address" required value="'.$fillEmail.'">
			
			<label for="country">Country</label>
			<select id="country" name="country">';
			
			$query ="SELECT * FROM countries";
			$result = @mysqli_query($MySQL, $query);
			while($row = @mysqli_fetch_array($result)) {
				if (($fillCountry == "" && $row['country_code'] == "HR") || ($row['country_code'] == $fillCountry)) {
					print '<option value="' . $row['country_code'] . '" selected>' . $row['country_name'] . '</option>';
				} else {
					print '<option value="' . $row['country_code'] . '">' . $row['country_name'] . '</option>';
				}
			}
			print '
			</select>
			
			<label for="city">City</label>
			<input type="text" id="city" name="city" placeholder="Enter city name" value="'.$fillCity.'">
			
			<label for="streetaddress">Street address</label>
			<input type="text" id="streetaddress" name="streetaddress" placeholder="Enter street address" value="'.$fillStreetaddress.'">
			
			<label for="dateofbirth">Date of birth</label>
			<input type="date" id="dateofbirth" name="dateofbirth" placeholder="Enter date of birth" value="'.$fillDateofbirth.'">
			
			<input type="submit" name="submitData" value="Submit registraton data">
		</form>
	</div>
';
?>