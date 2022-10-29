<?php
  print'
<!DOCTYPE html>
<html>';
  // Head
  include 'head.php';
  print'
  <body class="d-flex flex-column">
    <header>
      <div class="bmw-logo"></div>
    </header>';
    print'
    <nav>
      <ul>
        <li><a href="index.php?menu=1">Home</a></li>
        <li><a href="index.php?menu=2">News</a></li>
        <li><a href="index.php?menu=3">Contact</a></li>
        <li><a href="index.php?menu=4">About</a></li>
        <li><a href="index.php?menu=5">Gallery</a></li>
      </ul>
    </nav>
    <main'; 
    if ($_GET['menu'] == 2) { print ' class="d-flex flex-column"'; }
    print'>';

    // Homepage
    if (!isset($_GET['menu']) || $_GET['menu'] == 1) {
      include 'home.php';
    }
    // News
    else if ($_GET['menu'] == 2) { 
      include("news.php"); 
    }
    // Contact
    else if ($_GET['menu'] == 3) { 
      include("contact.php"); 
    }
    // About us
    else if ($_GET['menu'] == 4) { 
      include("about-us.php"); 
    }
    // Gallery
    else if ($_GET['menu'] == 5) { 
      include("gallery.php"); 
    }
    print '</main>';
    // Footer
    include 'footer.php';
    print'
  </body>
</html>';
?>