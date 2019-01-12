<?php 
	$message = "";
	if(isset($_POST['editusers'])){
		
		foreach($_POST as $name => $value) {
			$message = "User data saved!";
			if(substr($name,0,3) == "usr"){
				$userid = (int)substr($name,3);
				
				if ($value=="Removed"){
					# briši usera alp je odabrano "Delete user/Removed"
					$query ="DELETE FROM users WHERE userid=".$userid;
					$result = @mysqli_query($MySQL, $query);
				} else {
					# ako je bilo što drugo odabrano, postavi tu vrijednost u role
					$query ="UPDATE users SET role='".$value."' WHERE userid=".$userid;
					$result = @mysqli_query($MySQL, $query);
				}
			}
		}
	}

	print '
	<h1>User administration</h1>
	
	<form action="" id="user_editor" name="user_editor" method="POST">
	
	<table class="adminusers">
		<tr class="header">
			<th>&nbsp;User name</th>
			<th>&nbsp;First and last name</th>
			<th>&nbsp;E-mail address</th>
			<th>&nbsp;User role</th>
		</tr>
	';
		
	$query ="SELECT * FROM users";
	$result = @mysqli_query($MySQL, $query);
	$red = 0;
	while($row = @mysqli_fetch_array($result)) {
		$red++;
		print '
		<tr class="'.(($red%2==0) ? "odd" : "even").'">
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['username'].'</td>
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['firstname'].' '.$row['lastname'].'</td>
				<td class="'.(($red%2==0) ? "odd" : "even").'">'.$row['email'].'</td>
				<td class="adminusers">
					<select class="adminusers" id="usr'.$row['userid'].'" name="usr'.$row['userid'].'"'. ($row['username']==$_SESSION['anamUser']['user'] ? " disabled" : "") .'>
						<option value="Unconfirmed"'. ($row['role']=="Unconfirmed" ? " selected" : "") .'>Unconfirmed</option>
						<option value="User"'. ($row['role']=="User" ? " selected" : "") .'>User</option>
						<option value="Editor"'. ($row['role']=="Editor" ? " selected" : "") .'>Editor</option>
						<option value="Administrator"'. ($row['role']=="Administrator" ? " selected" : "") .'>Administrator</option>
						<option value="Removed">Delete user</option>
					</select>
				</td>
		</tr>';
	}
	print '
	</table>
	<br />
	<input type="submit" value="Save edited data" name="editusers">
	
	</form>
	<p class="centerparagraph">'.$message.'</p>
	';
	$message = "";
?>