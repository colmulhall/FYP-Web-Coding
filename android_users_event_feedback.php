<?php 

	//get the users data which was uploaded from the app
	if($_POST)
	{
    	$title = urldecode($_POST['title']);
    	$description = urldecode($_POST['description']);
    	$date = urldecode($_POST['date']);
    	$location = urldecode($_POST['location']);
    	$comment = urldecode($_POST['comment']);
    	$rating = urldecode($_POST['rating']);
        $category = urldecode($_POST['category']);
	}
      
        //convert rating to integer
        $the_rating = (int)$rating;

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
	
    	//Insert into the database
    	mysql_select_db($database, $connection);
	
    	$sql = "INSERT INTO user_feedback (ev_title, ev_desc, ev_location, the_date, comments, rating, category)
    		    VALUES
    			('$title', '$description', '$location', '$date', '$comment', '$the_rating', '$category')";

    	mysql_query($sql);
	
    	print "Inserted";
    }
    else 
    	print "Database NOT Found ";
	
	mysql_close($connection); 
	
?>