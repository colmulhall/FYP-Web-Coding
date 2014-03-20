<?php
	$username = 'a9517348_colm';
	$password = 'parkdbpass7';
	$database = 'a9517348_parkdb';
	$host = 'mysql5.000webhost.com';
 
 	//create connection to the database
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$database")or die("cannot select DB");

	
	//return all event titles from the database ordered by date
	$sql = "select id, title, location, date from event_list order by date";
	
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