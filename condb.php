<?PHP
$hostname = "localhost";
$username = "root";
$password = "";
$db = "parsermine";

// Create connection
$conn = new mysqli($hostname, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
    echo "DB Connected!";
}
/* select db */
mysqli_select_db($conn, $db);



