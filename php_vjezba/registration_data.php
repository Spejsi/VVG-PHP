<?php 
	
	# get user data from session
	$fillUsername = (!isset($_SESSION['fillUsername']) ? "-" : $_SESSION['fillUsername']);
	$fillPassword = (!isset($_SESSION['fillPassword']) ? "-" : $_SESSION['fillPassword']);
	$fillFirstname = (!isset($_SESSION['fillFirstname']) ? "-" : $_SESSION['fillFirstname']);
	$fillLastname = (!isset($_SESSION['fillLastname']) ? "-" : $_SESSION['fillLastname']);
	$fillEmail = (!isset($_SESSION['fillEmail']) ? "-" : $_SESSION['fillEmail']);
	$fillCountry = (!isset($_SESSION['fillCountry']) ? "-" : $_SESSION['fillCountry']);
	$fillCity = (!isset($_SESSION['fillCity']) ? "-" : $_SESSION['fillCity']);
	$fillStreetaddress = (!isset($_SESSION['fillStreetaddress']) ? "-" : $_SESSION['fillStreetaddress']);
	$fillDateofbirth = (!isset($_SESSION['fillDateofbirth']) ? "-" : $_SESSION['fillDateofbirth']);
	# get country name from database
	$query ="SELECT country_name FROM countries WHERE country_code='".$fillCountry."'";
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$fillCountry = $row['country_name'];
	
	print '
		<h1>Registration information</h1>
		<hr />
		<p class="centerparagraph">User <b>'.$fillUsername.'</b> is successfully registrated on our site with following data:</p>
		<hr />
		<table>
			<tr>
				<td class="label">Username:</td>
				<td class="value">'.$fillUsername.'</td>
			</tr>
			<tr>
				<td class="label">Password:</td>
				<td class="value">'.$fillPassword.'</td>
			</tr>
			<tr>
				<td class="label">First name:</td>
				<td class="value">'.$fillFirstname.'</td>
			</tr>
			<tr>
				<td class="label">Last name:</td>
				<td class="value">'.$fillLastname.'</td>
			</tr>
			<tr>
				<td class="label">E-mail:</td>
				<td class="value">'.$fillEmail.'</td>
			</tr>
			<tr>
				<td class="label">Country:</td>
				<td class="value">'.($fillCountry=="" ? "-" : $fillCountry).'</td>
			</tr>
			<tr>
				<td class="label">City:</td>
				<td class="value">'.($fillCity=="" ? "-" : $fillCity).'</td>
			</tr>
			<tr>
				<td class="label">Street address:</td>
				<td class="value">'.($fillStreetaddress=="" ? "-" : $fillStreetaddress).'</td>
			</tr>
			<tr>
				<td class="label">Date of birth:</td>
				<td class="value">'.($fillDateofbirth=="" ? "-" : $fillDateofbirth).'</td>
			</tr>
		</table>
		<hr />
		<p class="centerparagraph">You can now log in with new user name.</p>';
	
	# clear session data for this page after display
	unset($_SESSION['fillUsername']);
	unset($_SESSION['fillPassword']);
	unset($_SESSION['fillFirstname']);
	unset($_SESSION['fillLastname']);
	unset($_SESSION['fillEmail']);
	unset($_SESSION['fillCountry']);
	unset($_SESSION['fillCity']);
	unset($_SESSION['fillStreetaddress']);
	unset($_SESSION['fillDateofbirth']);
	
?>