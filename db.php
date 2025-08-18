<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "hishabify_db";

<<<<<<< HEAD
=======

//$conn = new mysqli("sql112.byethost31.com", "b31_39634701", "009251Aa@", "b31_39634701_hishabify_db");
>>>>>>> 8197fe9 ( add procedure in add branches and insert products)
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
