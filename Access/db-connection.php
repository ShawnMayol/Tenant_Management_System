<?php

$server = "localhost"; //if local
$uname = "root"; //defualt for localhost
$pword = ""; //default for localhost
$db = "tenant_management_system";

$conn = mysqli_connect($server, $uname, $pword, $db);

if(!$conn){
    die("Failed to connect to dabase: ".mysqli_connect_error());
}else{
    // echo "Successfully connected to the db";
}