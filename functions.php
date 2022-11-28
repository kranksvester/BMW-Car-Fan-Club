<?php 
	function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}
	
	function roleFromDatabaseToString($role) {
		if($role == 1) {
			return print 'Admin';
		}
		else if ($role == 2) {
			return print 'Editor';
		}
		else {
			return print 'User';
		}
		
	}

	function selectedRoleOptions($role) {
		if ($role == 1) {
			return '
				<option value="">Please select</option>
				<option value="1" selected>Admin</option>
				<option value="2">Editor</option>
				<option value="3">User</option>
			';
		} else if ($role == 2) {
			return '
				<option value="">Please select</option>
				<option value="1">Admin</option>
				<option value="2" selected>Editor</option>
				<option value="3">User</option>
			';
		} else if ($role == 2) {
			return '
				<option value="">Please select</option>
				<option value="1">Admin</option>
				<option value="2" selected>Editor</option>
				<option value="3">User</option>
			';
		} else {
			return '
				<option value="">Please select</option>
				<option value="1">Admin</option>
				<option value="2">Editor</option>
				<option value="3" selected>User</option>
			';
		}
	}

	function generatePassword($length = 20) {
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
		return substr(str_shuffle($chars),0,$length);
	}

	function generateUsername($firstname, $lastname) {
		// Have to use UTF-8 in order for croatian letters to work
		$username = mb_substr($firstname, 0, 1, "UTF-8");
		$username .= $lastname;
		return mb_strtolower($username, "UTF-8");
	}
?>