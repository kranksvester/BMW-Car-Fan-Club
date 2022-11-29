<?php 
	print '
	<h1>Sign In</h1>
	<div id="signin">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" name="myForm" id="myForm" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">

			<label for="username">Username:</label>
			<input type="text" id="username" name="username" value="" pattern=".{5,10}" placeholder="Username..." required>
									
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" value="" pattern=".{4,}" placeholder="Password..." required>
									
			<input type="submit" value="Submit">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($dbc, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (password_verify($_POST['password'], $row['password'])) {
			#password_verify https://secure.php.net/manual/en/function.password-verify.php
			$_SESSION['user']['valid'] = 'true';
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['firstname'] = $row['firstname'];
			$_SESSION['user']['lastname'] = $row['lastname'];
			$_SESSION['user']['role'] = $row['role'];
			$role = $_SESSION['user']['role'];
			$_SESSION['message'] = '<p>Welcome, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			if($role == 1) {
				# Redirect to admin/editor website
				header("Location: index.php?menu=7");
			} 
			else if ($role == 2) {
				# Redirect to editor website
				header("Location: index.php?menu=8");
			}
			else {
				# Redirect to homepage
				header("Location: index.php?menu=9");
			}
		}		
		# Bad username or password
		else {
			unset($_SESSION['user']);
			$_SESSION['message'] = '<p>You entered wrong email or password!</p>';
			header("Location: index.php?menu=6");
		}
	}
	print '
	</div>';
?>