<?php 

	//get the ID which was posted from the app
	if($_POST)
	{
    	$ID = urldecode($_POST['id']);
	}

	$host="localhost";
	$username="root";
	$password="";
	$db_name="park_events";
 
 	//create connection to the database
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	//returns the event from the database based on the POSTed ID
	$sql = "select title, description from event_list where id = $ID"; 
	
	$result = mysql_query($sql);
	$json = array();
 
 	//get each row of data from the database
	if(mysql_num_rows($result))
	{
    	while($row = mysql_fetch_assoc($result))
    	{
       	   	$json['event_list'][] = $row;
    	}
    	echo json_encode($json); 
	}
	mysql_close($con);
	
?>