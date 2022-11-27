<?php
    
	if (isset($action) && $action != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=" . $_GET['action'];
		$result = @mysqli_query($dbc, $query);
		$row = @mysqli_fetch_array($result);
			print '
			<div class="news">
				<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				<p>'  . $row['description'] . '</p>
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
			</div>';
	}
  else {
print'
    <h1>News</h1>';
    $query  = "SELECT * FROM news";
		$query .= " WHERE archive='N'";
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($dbc, $query);
		while($row = @mysqli_fetch_array($result)) {
			print '
			<section class="news">
        <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">
          <img 
            class="section-img" 
            src="news/' . $row['picture'] . '" 
            alt="' . $row['title'] . '" 
            title="' . $row['title'] . '"/>
        </a>
				<a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '" class="section-title section-links">' . $row['title'] . '</a>';
        print '<p class="section-p">';
				if(strlen($row['description']) > 300) {
					echo substr(strip_tags($row['description']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More ...</a>';
				} else {
					echo strip_tags($row['description']);
				}
        print '</p>
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
			</section>';
		}
  }
?>
