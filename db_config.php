<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "blog";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection is not established" . mysqli_connect_error());
}
?>
