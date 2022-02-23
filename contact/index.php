<?php
$submit = 'not submitted';
if(isset($_POST['name'])){
  $server = 'localhost';
  $username = 'root';
  $password = '';

  $conn = mysqli_connect($server, $username, $password);
  if(!$conn){
    die('Connection Failed: '.mysqli_connect_error());
  }
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];
  $sql = "INSERT INTO `elite_peak`.`contact`(`name`, `email`, `phone`, `message`, `timestamp`) VALUES ('$name','$email','$phone','$message',current_timestamp())";
  if($conn->query($sql) === true){
    $submit = 'submitted';
  }else {
    $submit = 'Submission Failed';
  }
  $conn->close();
}

include 'base.php';
include 'header.php';
?>
<div class="container">
    <img src="/Hotel/assets/images/phone.jpg" class="contact-img">
</div>
<div class="container mt-5 mb-5 px-4">
<form method="POST" action="index.php">
  <div class="form-group">
    <?php
    if($submit == 'submitted'){
      echo '<div class="alert alert-success" role="alert">
      Your message has been submitted.
      </div>';
    } else if ($submit == 'Submission Failed'){
      echo '<div class="alert alert-danger" role="alert">
      Your message has not been submitted.
      </div>';
    }
    ?>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput2">Name</label>
    <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Alex Hood" name="name" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput3">Phone</label>
    <input type="tel" class="form-control" id="exampleFormControlInput3" placeholder="+91-1234567890" name="phone" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Message</label>
    <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
  </div>
  <button class="btn btn-primary mt-4 mb-5" type="submit">Submit</button>
</form>
</div>
<script src="script.js"></script>