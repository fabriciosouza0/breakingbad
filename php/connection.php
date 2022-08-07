<?php  
		
	define('HOME', 'http://localhost/breakingbad');
	define('STYLE',  HOME.'/css/style.css');
	define('JS', HOME.'/js');

	$user = 'root';
	$pass = '';
	
	try {
		$con = new PDO("mysql:host=localhost; dbname=breaking_bad",$user,$pass);
	}catch(PDOException $ex) {
		echo $ex->getMessage();
	}

?>