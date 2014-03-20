<?php 

	//get the users data which was uploaded from the app
	if($_POST)
	{
    	$title = urldecode($_POST['title']);
    	$description = urldecode($_POST['description']);
    	$date = urldecode($_POST['date']);
    	$location = urldecode($_POST['location']);
    	$category = urldecode($_POST['category']);
    	$contact_link = urldecode($_POST['contact_link']);
	}

	//-------------------------CONNECTION AND INSERTION INTO DATABASE---------------------------
    $user_name = 'a9517348_colm';
    $password = 'parkdbpass7';
    $database = 'a9517348_parkdb';
    $host = 'mysql5.000webhost.com';

    $connection = mysql_connect($host, $user_name, $password);

    //Check connection-------------------------------------------------
    if (mysqli_connect_errno())
    	echo "Failed to connect to MySQL: " . mysqli_connect_error();
    else
    	echo "</br></br>Connected...</br>";

    //Check if database is found
    $db_found = mysql_select_db($database, $connection);
    
    if ($db_found)
    {
    	print "Database Found </br>";
	
    	// select database
    	mysql_select_db($database, $connection);

        //move onto the insert query
    	$sql = "INSERT INTO user_events (title, description, location, date, category, link_contact)
    	    	VALUES
    	    	('$title', '$description', '$location', '$date', '$category', '$contact_link')";

    	mysql_query($sql);
    		
    	print "Inserted";
    }
    else 
    	print "Database NOT Found ";
	
	mysql_close($connection); 
	
?>