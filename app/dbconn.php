<?php
$servername = "db"; 
$username = "root";
$password = "root";
$dbname = "uas_cloud_2212500108"; 

$conn = new mysqli("db", "root", "root", "uas_cloud_2212500108");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
