<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_phonebook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  //die("Connection failed: " . $conn->connect_error);
}

// SQL to create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

// Execute query and check if successful
if ($conn->query($sql) === TRUE) {

  echo "Database '$dbname' created successfully (or already exists).";

} else {

  echo "Error creating database: " . $conn->error;

}

// Select the database
$conn->select_db($dbname);

// SQL to create a table
$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(10) NOT NULL
)";

// Execute query and check if successful
if ($conn->query($sql) === TRUE) {

  echo "Table created successfully (or already exists).";

} else {

  echo "Error creating database: " . $conn->error;

}

return $conn;  // Ensure this returns the $conn object
?>