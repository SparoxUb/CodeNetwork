<?php

if (empty($_GET['Tofollow'])) {
    header("location:./");
}

session_start();

if (empty($username)) {
    header("location:./");
}

include "../includes/config.php";

$username = $_SESSION['username'];
$TOfollow = $_GET['Tofollow'];

///////check if already following 

$Query = $mysqli->query("SELECT id FROM follows WHERE username='$username' and following='$TOfollow' ;");
$check = $Query->fetch_assoc();

////DELETE existed following
$id = $check['id'];
$mysqli->query("DELETE FROM follows WHERE id='$id' ;");
