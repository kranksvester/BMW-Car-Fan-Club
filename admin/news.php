<?php 
	
	$loggedInUserRole=$_SESSION['user']['role'];

	#Add news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php

		$col = "title, description";

		if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
			$col .= "', archive'";
		}

		$query  = "INSERT INTO news ($col)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "'";

		if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
			$query .= "', '" . $_POST['archive'] . "'";
		}

		$query .= ")";
		$result = @mysqli_query($dbc, $query); var_dump($query); exit();
		
		$ID = mysqli_insert_id($dbc);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($dbc, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
		
		
		$_SESSION['message'] .= '<p>You successfully added news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	
	# Update news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_news') {
		$query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($dbc, $query);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
            
			$_picture = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$_POST['edit'] . " LIMIT 1";
				$_result = @mysqli_query($dbc, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
		
		$_SESSION['message'] = '<p>You successfully changed news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End update news
	
	# Delete news
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		# Delete picture
        $query  = "SELECT picture FROM news";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($dbc, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 
		
		# Delete news
		$query  = "DELETE FROM news";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($dbc, $query);

		$_SESSION['message'] = '<p>You successfully deleted news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End delete news
	
	
	#Show news info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($dbc, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>News overview</h2>
		<div class="news">
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['description'] . '
			<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
			<hr>
		</div>';
	}
	
	#Add news 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Add news</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="title">Title:</label>
			<input type="text" id="title" name="title" placeholder="News title.." required>

			<label for="description">Description:</label>
			<textarea id="description" name="description" placeholder="News description.." required></textarea>
				
			<label for="picture">Picture:</label>
			<input type="file" id="picture" name="picture">';

			if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
				print '	
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"> Yes &nbsp;&nbsp;
			<input type="radio" name="archive" value="N" checked> No';
			}
			print '
			<hr>
			
			<input type="submit" value="Submit">
		</form>';
	}
	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($dbc, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;

		print '
		<h2>Edit news</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="title">Title:</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="News title.." required>

			<label for="description">Description:</label>
			<textarea id="description" name="description" placeholder="News description.." required>' . $row['description'] . '</textarea>
				
			<label for="picture">Picture:</label>
			<input type="file" id="picture" name="picture">';
			
			if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
				print '
				<label for="archive">Archive:</label><br />
				<input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> Yes &nbsp;&nbsp;
				<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> No';
			}
			
			print '
			<hr>
			
			<input type="submit" value="Submit">
		</form>';
	}
	else {
		print '
		<h2>List of News</h2>
		<div id="news">
			<table>
				<thead>
					<tr>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>
						<th width="16"></th>
						<th width="16"></th>';
						if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
							print '
							<th width="16"></th>';
						}
						if ($loggedInUserRole == 1) {
							print '
							<th width="16"></th>';
						}
					print '
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($dbc, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . pickerDateToMysql($row['date']) . '</td>
						<td>';
							if ($row['archive'] == 'Y') { print '<img src="icons/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="icons/active.png" alt="" title="" />'; }
						print '
						</td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="icons/article.png" alt="user"></a></td>';
						if ($loggedInUserRole == 1 || $loggedInUserRole == 2) {
							print '<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="icons/edit.png" alt="edit"></a></td>';
						}
						if ($loggedInUserRole == 1) {
							print '
							<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="icons/delete.png" alt="delete"></a></td>';
						}
					print '	
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add news</a>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($dbc);
?>