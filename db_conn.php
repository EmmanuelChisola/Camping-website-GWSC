<?php

$sname = "localhost";
$user = "root";
$passcode = "";

$db_name = "gwsc_db";
$conn = mysqli_connect($sname,$user,$passcode,$db_name);

if (!$conn){
    echo "Connection failed!";
}