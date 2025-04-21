<?php

// 

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name.  All our classes will be in a directory
// that Apache does not serve publicly.  They will be in /opt/src/, which
// is our src/ directory in Docker.
spl_autoload_register(function ($classname) {
        include "/opt/src/Swipeify/$classname.php";
        // include "/students/rze7ud/students/rze7ud/private/Swipeify/$classname.php";
});

// Instantiate the front controller
$swipeify = new SwipeController($_GET);

// Run the controller
$swipeify->run();
