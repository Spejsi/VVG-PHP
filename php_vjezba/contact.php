<?php 

if (isset($_POST['sendMail'])){
	$EmailHeaders  = "MIME-Version: 1.0\r\n";
	$EmailHeaders .= "Content-type: text/html; charset=utf-8\r\n";
	$EmailHeaders .= "From: <space.dancer@gmail.com>\r\n";
	$EmailHeaders .= "Reply-To:<space.dancer@gmail.com>\r\n";
	$EmailHeaders .= "X-Mailer: PHP/".phpversion();
	$EmailSubject = 'Message from New Age Acoustic Music page';
	$EmailBody  = '
	<html>
	<head>
	   <title>New Age Acoustic Music page message</title>
	   <style>
		body {
		  background-color: #ffffff;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 16px;
			padding: 0px;
			margin: 0px auto;
			width: 500px;
			color: #000000;
		}
		p {
			font-size: 14px;
		}
		a {
			color: #00bad6;
			text-decoration: underline;
			font-size: 14px;
		}
		
	   </style>
	   </head>
	<body>
		<p>Sender: '.$_POST['firstname'].' '.$_POST['lastname'].' from '.$_POST['country'].'</p>
		<p>E-mail address of sender: '.$_POST['email'].'</p>
		<br /><p>Message:<p>
		<p>'.$_POST['subject'].'</p>
	</body>
	</html>';
	mail("space.dancer@gmail.com", $EmailSubject, $EmailBody, $EmailHeaders);
	$message = "Message sent to owner!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	header("Location: index.php?menu=1");
}

print '
	<h1>Contact Form</h1>
	<div id="contact">
		
		<div class="with-border">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2785.713003738147!2d16.076133800000004!3d45.71679410000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47667e64ba15fc3f%3A0xb770d64aefe1b657!2zxaBldGFsacWhdGUgRnJhbmplIEx1xI1pxIdhIDI5LCAxMDQxMCwgVmVsaWthIEdvcmljYQ!5e0!3m2!1sen!2shr!4v1544225359392" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
		<hr/>
		<form action="index.php?menu=3" id="contact_form" name="contact_form" method="POST">
			<label for="firstname">First Name *</label>
			<input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>

			<label for="lastname">Last Name *</label>
			<input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
			
			<label for="email">E-mail address *</label>
			<input type="email" id="email" name="email" placeholder="Enter your e-mail address" required>

			<label for="country">Country</label>
			<select id="country" name="country">';
			
		$query ="SELECT * FROM countries";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			if ($row['country_code'] == "HR") {
				print '<option value="' . $row['country_name'] . '" selected>' . $row['country_name'] . '</option>';
			} else {
				print '<option value="' . $row['country_name'] . '">' . $row['country_name'] . '</option>';
			}
		}
		
		print '
			</select>

			<label for="subject">Subject</label>
			<textarea id="subject" name="subject" placeholder="Write message..." style="height:200px"></textarea>

			<input type="submit" value="Submit" name="sendMail">
		</form>
	</div>
';
?>