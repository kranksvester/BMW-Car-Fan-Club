<?php

  # Stop Hacking attempt
  define('__APP__', TRUE);
    
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  # Start session
  session_start();

  # Database connection
	include ("dbc.php");

  # Variables MUST BE INTEGERS
  if(isset($_GET['menu'])) { $menu   = (int)$_GET['menu']; }
	if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
	
	# Variables MUST BE STRINGS A-Z
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
	
	if (!isset($menu)) { $menu = 1; }

  # Classes & Functions
  include_once("functions.php");

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
    <nav>';
      include 'menu.php';
    print '</nav>
    <main'; 
    if ($menu == 2) { 
      print ' class="d-flex flex-column"'; 
    }
    print'>';

    if (isset($_SESSION['message'])) {
			print $_SESSION['message'];
			unset($_SESSION['message']);
		}

    // Homepage
    if (!isset($menu) || $menu == 1) {
      include 'home.php';
    }
    // News
    else if ($menu == 2) { 
      include("news.php"); 
    }
    // Contact
    else if ($menu == 3) { 
      include("contact.php"); 
    }
    // About us
    else if ($menu == 4) { 
      include("about-us.php"); 
    }
    // Register
    else if ($menu == 5) { 
      include("register.php"); 
    }
    // Sign In
    else if ($menu == 6) { 
      include("sign-in.php"); 
    }
    // Sign In
    else if ($menu == 7 || $menu == 8 || $menu == 9) { 
      include("admin.php"); 
    }

    print '</main>';
    // Footer
    include 'footer.php';
    print'
  </body>
</html>';
?>