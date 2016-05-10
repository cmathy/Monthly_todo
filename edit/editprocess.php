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

$day = $_GET['day'];
$tasks = $_GET['tasks'];

$q = "UPDATE WeeklyTodo SET Tasks=  '" . $tasks . "' WHERE day= " . $day;
$result = mysql_query($q);
if(!$result) {
    die('<br/>MySQL Error: ' . mysql_error());
}

header('Location: http://christophermathy.com/Monthly_todo/');
?>