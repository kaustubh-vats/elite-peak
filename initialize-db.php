<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $conn = new mysqli($servername, $username, $password);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE DATABASE elite_peak";
  if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
  } else {
    echo "Error creating database: " . $conn->error;
  }
  echo "<br>";
  $conn->close();
?>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "elite_peak";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE TABLE rooms (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  typename VARCHAR(100),
  descript VARCHAR(10000),
  img VARCHAR(1000),
  price INT(7),
  available INT(7)
  )";

  if ($conn->query($sql) === TRUE) {
    echo "Table rooms created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  echo '<br>';
  $conn->close();
?>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "elite_peak";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE TABLE contact (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name TEXT,
  email VARCHAR(255),
  phone VARCHAR(13),
  message TEXT,
  timestamp TIMESTAMP default CURRENT_TIMESTAMP
  )";

  if ($conn->query($sql) === TRUE) {
    echo "Table contact created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  echo '<br>';
  $conn->close();
?>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "elite_peak";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE TABLE room_booking (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(256),
  email VARCHAR(256),
  phone INT(13),
  room_type VARCHAR(100),
  nights INT(3),
  payment INT(10),
  booked_number INT(3),
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  )";

  if ($conn->query($sql) === TRUE) {
    echo "Table room_booking created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  echo '<br>';
  $conn->close();
?>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "elite_peak";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE TABLE promo_codes (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(30),
  discount INT(3)
  )";

  if ($conn->query($sql) === TRUE) {
    echo "Table promo_codes created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  echo '<br>';
  $conn->close();
?>

<?php
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $conn = mysqli_connect($server, $username, $password);
  if(!$conn){
    die('Connection Failed: '.mysqli_connect_error());
  }

  $sql = "INSERT INTO `elite_peak`.`rooms` (`typename`,`descript`,`img`,`price`,`available`) 
    VALUES 
    ('Standard Rooms','The serene surrounding will add to your relaxation here. We ensure you have ample space to relax.','/elite-peak/assets/images/room1.jpg','6999','100'),
    ('Family Rooms','It''s a home away from home. We bring you ample spaces to enjoy the serenity in.','/elite-peak/assets/images/room2.jpg','7999','100'),
    ('Single Roooms','Let us make your stay the most memorable - every time. You will keep coming back after your first stay. The food and drinks are the talks of the country.','/elite-peak/assets/images/room3.jpg','4999','100'),
    ('Deluxe Rooms','Be in a class by yourself when you stay with us. Live in the elegant comfort we have in store for you.','/elite-peak/assets/images/room4.jpg','8999','100'),
    ('Luxury Rooms','Stay with us and enjoy the luxuries meant for royalty alone. True luxury for you in the lap of nature. Your stay with us is what we cherish the most.','/elite-peak/assets/images/room5.jpg','12999','100'),
    ('AC Rooms','Stay and relax with us, and be recharged for that rigmarole again. An experience you will love to reminisce about all your life.','/elite-peak/assets/images/room6.jpg','3499','100');";
  if($conn->query($sql) === true){
    echo 'Success';
  } else {
    echo 'Error: '.$sql.'<br>'.$conn->error;
  }
  $conn->close();
  echo '<br>';
?>

<?php
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $conn = mysqli_connect($server, $username, $password);
  if(!$conn){
    die('Connection Failed: '.mysqli_connect_error());
  }

  $sql = "INSERT INTO `elite_peak`.`promo_codes` (`code`,`discount`) 
    VALUE
    ('SUMMER50','50');";
  if($conn->query($sql) === true){
    echo 'Success';
  } else {
    echo 'Error: '.$sql.'<br>'.$conn->error;
  }
  $conn->close();
?>