<?php
	
	$host="localhost";
	$username="root";
	$password="";
	$db_name="park_events";
 
 	//create connection to the database
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");

	
	//return all event titles from the database ordered by date
	$sql = "select id, title, date from news_updates order by date"; 
	
	$result = mysql_query($sql);
	$json = array();
 
 	//get each row of data from the database
	if(mysql_num_rows($result))
	{
    	 	while($row = mysql_fetch_assoc($result))
    	 	{
       	   		$json['news_updates'][] = $row;
    		}
    		echo json_encode($json); 
	}
	mysql_close($con);
?>