<?php



include 'header.php';



$queryString = $_SERVER['QUERY_STRING'];

$query = "SELECT VG.*, C.Id 'ConsoleId', C.Name 'ConsoleName' 
	FROM VideoGame VG
			INNER JOIN Console C ON C.Id = VG.Console_Id
	WHERE VG.Id = '".$queryString."' LIMIT 1";



include 'dbquery.php'; //provides $result

if ($result == null)

	die("Query has provided no results.");



$data = $result[0];



echo "<h1>".$data["Rank"]." : ".$data["Name"]." - The Definitive 50 ".$data["ConsoleName"]." Games</h1><p>NA Game Release Date: ".date_format(date_create($data["ReleaseDate"]), "F jS, Y")."</p>";



echo "<div class=videoWrap><iframe width=560 height=315 src=https://www.youtube.com/embed/".$data[

"VideoURL"]." frameborder=0 allowfullscreen></iframe></div>";



echo $data["Transcript"]."";



echo "<p>Let Team Splodinator know what you think of ".$data["Name"]." and the Definitive 50 ".$data["ConsoleName"]." Games: Leave a comment on our Youtube Videos. <a href=https://www.youtube.com/subscription_center?add_user=Definitive50>Subscribe to the Definitive 50 on Youtube!</a></p>";



$query = "SELECT VG.Id, VG.Name, Rank 
	FROM VideoGame  VG
		INNER JOIN Console C ON C.Id = VG.Console_Id
	WHERE Rank + 1 = '".$data["Rank"]."' 
		AND C.Name = '".$data["ConsoleName"]."' 
	LIMIT 1";
include 'dbquery.php'; //provides $result

$higherData = $result[0];

if ($higherData != null) {

	echo "<a href=\"view.php?".$higherData["Id"]."\">";

	echo "<< ".$higherData["Rank"]." : ".$higherData["Name"];

	echo "</a>&nbsp;";

}



	echo "<a href=list.php?".$data["ConsoleId"].">Return to&nbsp;".$data["ConsoleName"]."&nbsp;list</a>";

	

$query = "SELECT VG.Id, VG.Name, Rank 
	FROM VideoGame  VG
		INNER JOIN Console C ON C.Id = VG.Console_Id
	WHERE Rank - 1 = '".$data["Rank"]."' 
		AND C.Name = '".$data["ConsoleName"]."' 
	LIMIT 1";

include 'dbquery.php'; //provides $result

$lesserData = $result[0];

if ($lesserData != null) {

	echo "&nbsp;<a href=\"view.php?".$lesserData["Id"]."\">";

	echo $lesserData["Rank"]." : ".$lesserData["Name"]." >>";

	echo "</a>";

	

	

}



		echo "</p><p><a href=index.php>Return to index</a></p>";

?>
