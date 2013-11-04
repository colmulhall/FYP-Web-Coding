<?php

	$user_name = 'root';
	$password = '';
	$database = 'park_events';
	$server = '127.0.0.1';

	$connection = mysql_connect($server, $user_name, $password);

	//Check connection-------------------------------------------------
	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	else
		echo "Connected...</br>";

	//Check if database is found
	$db_found = mysql_select_db($database, $connection);
	if ($db_found)
	{
		print "Database Found ";
	}
	else 
	{
		print "Database NOT Found ";
	}
	//-----------------------------------------------------------------
	
	
	//Insert into the database
	mysql_select_db($database, $connection); 
	
	$sql = "INSERT INTO event_list (title, description, date, category)
	VALUES
	('The Title','There will be a charity auction in the park at 1pm. All welcome.', '2013-11-05', 'Charity')";

	mysql_query($sql); 

	mysql_close($connection);

?>