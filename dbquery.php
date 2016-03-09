<?php
if ($query == null)
	die("Query has not been provided");

$username = "user";
$password = "pw";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db("db", $dbhandle) 
  or die("Could not select Video Game");

//execute the SQL query and return records
$queryResult = mysql_query($query);

$result = array();
while ($row = mysql_fetch_array($queryResult)) {
	$result[] = $row;
}

//close the connection
mysql_close($dbhandle);
?>
