<?php
	$host="localhost";
	$username="root";
	$password="";
	$db_name="park_events";
 
 	//create connection to the database
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");

	//get string from android
	if (isset($_POST['action']))
		echo "";
	if($title == "")
		echo "NOTHING";
	else
		echo $title;

	mysql_close($con);
?>