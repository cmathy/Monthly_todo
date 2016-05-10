<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Weekly To Do List</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<?php

		// DB info
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

	?>
	<div id="container">
		<h1>Weekly Todo List</h1>

			<?php
			// Query to check what day number is in the first slot of db
			$q = "SELECT * FROM WeeklyTodo where id= '1'";
			$result = mysql_query($q);
			if(!$result) {
			    die('<br/>MySQL Error: ' . mysql_error());
			} else {
			    $row = mysql_fetch_array($result);
		        $dayNum = $row['day'];
			}

			// Loop that checks if the day num in the first slot matches the actual day num.
			// If it doesn't then it moves the contents of each day up one slot continuously
			// until the day nums in the db line up with the actual day nums. Then it renders
			// the contents of the DB once they are all lined up properly.
			while ($dayNum != date('j')) {
				$dayNum ++;
				echo $dayNum . date('j');

				for ($x = 1; $x <= 8; $x++) {
					if ($x < 8) {
						// Select contents of a DB slot
						$q = "SELECT * FROM WeeklyTodo where id= '" . ($x + 1) . "'";
						$result = mysql_query($q);
						if(!$result) {
						    die('<br/>MySQL Error: ' . mysql_error());
						} else {
						    $row = mysql_fetch_array($result);
					        $day = $row['day'];
					        $tasks = $row['Tasks'];
						}

						// enter contents selected DB slot into the DB slot above the selected DB slot
						$q = "UPDATE WeeklyTodo SET day= '" . $day . "', Tasks=  '" . $tasks . "' WHERE id= " . $x;
						$result = mysql_query($q);
						if(!$result) {
						    die('<br/>MySQL Error: ' . mysql_error());
						}
					} else {

						// Update last DB slot with fresh stuff
						// Chunk below gets the day number of the last day in the stack
						$q = "SELECT * FROM WeeklyTodo where id= '" . $x . "'";
						$result = mysql_query($q);
						if(!$result) {
						    die('<br/>MySQL Error: ' . mysql_error());
						} else {
						    $row = mysql_fetch_array($result);
					        $day = $row['day'];
						}

						// Chunk below updates the last slot with blank content and a day number
						// based on the daynumber that was previously in it.
						$q = "UPDATE WeeklyTodo SET day= '" . ($day + 1) . "', Tasks=  '' WHERE id= " . $x;
						$result = mysql_query($q);
						if(!$result) {
						    die('<br/>MySQL Error: ' . mysql_error());
						}
					}
				}
			}

			// DB Content Rendering once/if all the content is updated
			for ($x = 1; $x <= 8; $x++) {
				$q = "SELECT * FROM WeeklyTodo where id= '" . $x . "'";
				$result = mysql_query($q);
				if(!$result) {
				    die('<br/>MySQL Error: ' . mysql_error());
				} else {
				    $row = mysql_fetch_array($result);
			        $tasks = $row['Tasks'];
			        $day = $row['day'];
				}
				echo '<div class="day"><h2>' . date("F") . ' ' . $day . '</h2><p>' . $tasks . '</p>
				<form action="edit/" method="get">
					<input type="hidden" name="day" value=' . $day . '>
					<input type="submit" value="Edit">
				</form></div>';
			}
			
			?>

	</div>
	<?php
		mysql_close($link);
	?>
</body>

</html>