<?php 
	
	$fillUsername = (!isset($_POST['loginusername']) ? "" : $_POST['loginusername']);
	$fillPassword = (!isset($_POST['loginpassword']) ? "" : $_POST['loginpassword']);
	
	print '
	
	<form action="index.php?menu=6" id="login_form" name="login_form" method="POST">
		<h1>Login form</h1>
		
		<div id="loginform">
			Enter user name and password:
			<hr/>
			<label for="loginusername">User name *</label>
			<input type="text" id="loginusername" name="loginusername" placeholder="Enter your user name" required value="'.$fillUsername.'">
			
			<label for="loginpassword">Enter password *</label>
			<input type="password" id="loginpassword" name="loginpassword" placeholder="Enter password" required value="'.$fillPassword.'">
			
			<input type="submit" name="loginEntered" value="Login">
		</form>
	</div>';
	
	if(isset($_POST['loginEntered'])){
		$query ="SELECT * FROM users WHERE username='".strtolower($fillUsername)."'";
		
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		# print '"'.$row['username'].'"<br />';
		
		if(!password_verify($fillPassword, $row['password'])){
			print '<p class="loginerror">Username or password did not match!</p>';
		} else {
			# postavi u session usera
			$_SESSION['anamUser']['name'] = $row['firstname']." ".$row['lastname'];
			$_SESSION['anamUser']['user'] = $row['username'];
			$_SESSION['anamUser']['role'] = $row['role'];
			header("Location: index.php?menu=1");
		}
	}

	
?>