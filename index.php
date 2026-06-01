<?php
	
	// start the session
	session_start();
	
	// read the configuration file
	include 'config.php';

	// call the main function class
	include 'utils/common.class.php';
	
	// call the class responsible for logging into the database
	include 'utils/mysql.class.php';


    include 'utils/validator.class.php';


    include 'utils/paging.class.php';


    include 'libraries/brands.class.php';
	include 'libraries/member.class.php';
    include 'libraries/attendance.class.php';
    include 'libraries/personal_training_session.class.php';
    include 'libraries/payments.class.php';
	include 'libraries/F2.class.php';

	
	// set the selected module
	$module = '';
	if(isset($_GET['module'])) {
		$module = mysql::escapeFieldForSQL($_GET['module']);
	}
	
	// if an element is selected (contract, car, etc.) set the element id
	$id = '';
	if(isset($_GET['id'])) {
		$id = mysql::escapeFieldForSQL($_GET['id']);
	}
	
	// set which function is being called
	$action = '';
	if(isset($_GET['action'])) {
		$action = mysql::escapeFieldForSQL($_GET['action']);
	}
		
	// set the element list page number
	$pageId = 1;
	if(!empty($_GET['page'])) {
		$pageId = mysql::escapeFieldForSQL($_GET['page']);
	}
	
	// set which controller to include in the template main.tpl.php
    $actionFile = "";
    if(!empty($module) && !empty($action)) {
        $actionFile = "controls/{$module}/{$module}_{$action}.php";
    } else {
        // use this if no parameter are set
        $actionFile = "controls/home_page.php";
    }
	
	// include main template
	include 'templates/main.tpl.php';
	
	// print the executed queries in the console
    if(array_key_exists('queries', $_SESSION)) {
        common::logToConsole($_SESSION['queries']);
    }
	
	// clear the executed queries array
	$_SESSION['queries'] = array();
?>