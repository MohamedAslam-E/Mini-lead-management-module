<?php
$db_server = "localhost";
$db_user = "root";
$db_ps = "";
$db_name = "lead";

$conn = mysqli_connect($db_server, $db_user, $db_ps, $db_name);

if (!$conn) {
  "connection error";
}