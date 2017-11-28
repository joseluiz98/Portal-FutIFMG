<?php
$dbuser = "root";
$dbpass = "adminifmg";
$dbname = "db_portal";

/*$conn = new PDO("mysql:host=localhost;dbname=".$dbname, $dbuser, $dbpass, 
    array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/

	define('DB_HOST', 'localhost');
	define('DB_SCHEMA', 'db_portal');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'adminifmg');
	define('DB_ENCODING', 'utf8');


	$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA;
	$options = array(
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	);

	if( version_compare(PHP_VERSION, '5.3.6', '<') ){
	    if( defined('PDO::MYSQL_ATTR_INIT_COMMAND') ){
	        $options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . DB_ENCODING;
	    }
	}else{
	    $dsn .= ';charset=' . DB_ENCODING;
	}

	$conn = @new PDO($dsn, DB_USER, DB_PASSWORD, $options);

	if( version_compare(PHP_VERSION, '5.3.6', '<') && !defined('PDO::MYSQL_ATTR_INIT_COMMAND') ){
	    $sql = 'SET NAMES ' . DB_ENCODING;
	    $conn->exec($sql);
	}
?>