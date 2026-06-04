
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "industry_db";

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}