<?php
	$host="localhost";
	$username="root";
	$password="";
	$db_name="park_events";
 
 	//create connection to the database
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	//run an sql query to return data from the database
	$sql = "select title from event_list order by id"; 
	
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