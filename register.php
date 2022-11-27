<?php 
    print '
	<h1>Registration</h1>
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="fname">First Name: </label>
			<input type="text" id="fname" name="firstname" placeholder="Your name..." required>

			<label for="lname">Last Name: </label>
			<input type="text" id="lname" name="lastname" placeholder="Your last name..." required>
				
			<label for="email">Your E-mail: </label>
			<input type="email" id="email" name="email" placeholder="Your e-mail..." required>
			
			<label for="username">Username: <small>(Username must have min 5 and max 10 char)</small></label>
			<input type="text" id="username" name="username" pattern=".{5,10}" placeholder="Username..." required><br>
			
									
			<label for="password">Password: <small>(Password must have min 4 char)</small></label>
			<input type="password" id="password" name="password" placeholder="Password..." pattern=".{4,}" required>

			<label for="country">Country:</label>
			<select name="country" id="country">
				<option value="">Please select</option>';
				#Select all countries from database projektdb, table countries
                $query  = "SELECT * FROM countries";
				$result = @mysqli_query($dbc, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['iso'] . '">' . $row['nicename'] . '</option>';
				}
			print '
			</select>

            <label for="city">City: </label>
			<input type="text" id="city" name="city" placeholder="Your city..." required>

            <label for="address">Address: </label>
			<input type="text" id="address" name="address" placeholder="Your current address..." required>

            <label for="dob">Date of birth: </label>
			<input type="date" id="dob" name="dob" placeholder="Your date of birth..." required>

			<input type="submit" value="Register">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($dbc, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (empty($row) || $row['email'] == '' || $row['username'] == '') {
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO users (firstname, lastname, email, username, password, country, city, address, dob)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "', '" . $_POST['city'] . "', '" . $_POST['address'] . "', '" . $_POST['dob'] . "' )";
			$result = @mysqli_query($dbc, $query);
			echo '<p>' . ucfirst(strtolower($_POST['firstname'])) . ' ' .  ucfirst(strtolower($_POST['lastname'])) . ', thank you for registration </p>
			<hr>';
		}
		else {
			echo '<p>User with this email or username already exist!</p>';
		}
	}
	print '
	</div>';
?>