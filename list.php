<?php



include 'header.php';

			

$queryString = $_SERVER['QUERY_STRING'];

if (strpos($queryString, '&'))
{
	$split = explode('&', $queryString);
	$consoleId = $split[0];
	$sortType = $split[1];
}
else
{
	$consoleId = $queryString;
	$sortType = "Rank";
}

$query = "SELECT Name FROM Console WHERE Id = ".$consoleId." LIMIT 1";
include 'dbquery.php';
$consoleName =  $result[0]["Name"];

$query = "SELECT Id,
		Name, 
		Rank,
		Thumbnail,
		ReleaseDate,
		Transcript, 
		(
			SELECT GROUP_CONCAT(D2.Name SEPARATOR ', ') 
			FROM Developer D2
				INNER JOIN VideoGameDeveloper VGD ON VGD.Developer_Id = D2.Id
			WHERE VGD.VideoGame_Id = VG.Id
			ORDER BY D2.Name
		) AS 'Developer',
		(
			SELECT GROUP_CONCAT(Genre.Name SEPARATOR ', ') 
			FROM Genre
				INNER JOIN VideoGameGenre ON VideoGameGenre.Genre_Id = Genre.Id
			WHERE VideoGameGenre.VideoGame_Id = VG.Id
			ORDER BY Genre.Name
		) AS 'Genre',
		(
		SELECT GROUP_CONCAT(Publisher.Name SEPARATOR ', ') 
			FROM Publisher
				INNER JOIN VideoGamePublisher ON VideoGamePublisher.Publisher_Id = Publisher.Id
			WHERE VideoGamePublisher.VideoGame_Id = VG.Id
			ORDER BY Publisher.Name
		) AS 'Publisher'

	FROM VideoGame VG
	WHERE Console_Id = ".$consoleId.
	" ORDER BY ".$sortType;

include 'dbquery.php';
if ($result == null)
	die("Query has provided no results.");


echo '<h1>The Definitive 50 '.$consoleName.' Games</h1><p>Sort by: <a href="list.php?'.$consoleId.'&Rank">Rank</a>, <a href="list.php?'.$consoleId.'&Name">Name</a>, <a href="list.php?'.$consoleId.'&ReleaseDate">Year</a>, <a href="list.php?'.$consoleId.'&Developer">Developer</a>, <a href="list.php?'.$consoleId.'&Genre">Genre</a></p>

<table> <tr>
	<th class="thumb"></th>
    <th class="slim">Rank</th>
	<th></th>
	<th class="slim">Genre</th>
	<th class="slim">Developer</th>
	<th class="slim">Publisher</th>
	<th class="slim">Year</th>
 </tr>';


$counter = 0;
foreach ($result as $row) {

	$className = $counter % 2 == 0 ? "even" : "odd";

	$display = '<tr class="'.$className.'"><td rowspan=2 class="thumb">

		<a href="view.php?'.$row["Id"].'"><img src="http://csidephotography.com/sandbox/thumbnails/'.$consoleName."/"

		.$row["Thumbnail"].'" width=300 height=168></a></td><td class="slim">'

		.$row["Rank"].'.</td><td class="gamename"><a href="view.php?'.$row["Id"].'">'

		.$row["Name"].'</a></td><td class="slim">'
		
		.$row["Genre"].'</td><td class="slim">'
		
		.$row["Developer"].'</td><td class="slim">'
		
		.$row["Publisher"].'</td><td class="slim">'

		.date_format(date_create($row["ReleaseDate"]), "Y").'</td></tr><tr class="'.$className.'"><td colspan=6>';

		

	$transcript = strip_tags($row["Transcript"]);	
	
	
	if ($transcript != null && strlen($transcript) >= 144)

		$transcript = substr($transcript, 0, 140).'... <a href="view.php?'.$row["Id"].'">Continue reading >></a>';

	

	echo $display.$transcript.'</td></tr>';

	++$counter;
}



		echo "</table>

		<p><a href=index.php>Return to index</a></p>";

		

?>
