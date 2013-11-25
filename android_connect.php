<?php
	$user_name = 'root';
	$password = '';
	$database = 'park_events';
	$server = '127.0.0.1';

	//This opens up a connection to the database and fetches information for the android app. 
	//The app connects to this script.
	
	$connection = mysql_connect($server, $user_name, $password);
	mysql_select_db($database, $connection);
 
	$sql = mysql_query("select * from event_list where id = 34");
	while($row = mysql_fetch_assoc($sql))
	{
		$output[] = $row;
	}
	
	print(json_encode($output));    //this will print the output in json
	
	mysql_close($connection);
?>