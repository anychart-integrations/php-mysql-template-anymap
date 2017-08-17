<?php
// Define MySQL connection data
$MYSQL['host'] = "localhost";
$MYSQL['user'] = "anychart_user";
$MYSQL['password'] = "anychart_pass";
$MYSQL['database'] = "anychart_db";

$placesSelected = implode("','",$_POST['selected']);
$placesUnSelected = implode("','",$_POST['unSelected']);

// Connect to MySQL database
$mysqli = mysqli_connect($MYSQL['host'], $MYSQL['user'], $MYSQL['password'], $MYSQL['database']);

$sql = "UPDATE place SET selected='true' WHERE id in('{$placesSelected}')";
$mysqli->query($sql);

$sql = "UPDATE place SET selected='false' WHERE id in('{$placesUnSelected}')";
$mysqli->query($sql);

$mysqli->close();
?>