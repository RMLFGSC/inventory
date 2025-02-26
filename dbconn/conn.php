<?php

$host = "192.168.80.73";
$username = "root";
$password = "";
$database = "newgmc";

$conn = mysqli_connect("$host", "$username", "$password", "$database");

if(!$conn)
{
    echo " DATABASE CONNECTION FAILED";
    die();
}

?>