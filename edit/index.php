<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Weekly To Do List Edit Day</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
	<?php

		// DB info and connection
		$hostname="db622767349.db.1and1.com";
		$database="db622767349";
		$username="dbo622767349";
		$password="12tears";

		$link = mysql_connect($hostname, $username, $password);
		if (!$link) {
			die('Connection failed: ' . mysql_error());
		}

		$db_selected = mysql_select_db($database, $link);
		if (!$db_selected) {
		    die ('Can\'t select database: ' . mysql_error());
		}

		// Get day number from url and select contents from the corresponding DB space
		$day = $_GET['day'];

		$q = "SELECT * FROM WeeklyTodo where day= " . $day;
		$result = mysql_query($q);
		if(!$result) {
		    die('<br/>MySQL Error: ' . mysql_error());
		} else {
		    $row = mysql_fetch_array($result);
	        $tasks = $row['Tasks'];
		}
	?>
	<div id="container">
		<h1>Edit May <?php echo $day; ?></h1>

		<form action="editprocess.php" method="get">
			<input type="hidden" name="day" value= <?php echo '"' . $day . '"'; ?> >
			<textarea rows="5" cols="50" name="tasks"><?php echo $tasks ?></textarea><br>
			<input type="submit" value="Submit">
		</form>

	</div>
	<?php
		mysql_close($link);
	?>
</body>

</html>