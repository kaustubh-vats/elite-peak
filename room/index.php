<?php
include 'base.php';
include 'header.php';
$price = array();
$submit = 'not submitted';
$error = '';
$priceToBePid = 0;

function calculatePrice($roomPrice, $number_of_rooms, $nights, $discount) {
  $roomPrice = $roomPrice * $number_of_rooms * $nights;
  return $roomPrice - ($discount/100 * $roomPrice);
}
function updateMyDB(&$submit, &$error, &$priceToBePid) {
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'elite_peak';
  $discount = 0;
  $roomPrice = 0;

  $promo = $_POST['promo'];
  $conn = new mysqli($server, $username, $password, $dbname);
  if($promo != ''){
    if($conn->connect_error){
      die('Connection Failed: '.$conn->connect_error);
    }
    $sql = "SELECT code, discount FROM promo_codes where code = '$promo'";
    $result = $conn->query($sql);
    if($result -> num_rows > 0){
      $discount = $result->fetch_assoc()['discount'];
    }
  }
  
  $type = $_POST['type'];
  $number_of_rooms = $_POST['number_of_rooms'];
  $sql = "SELECT available, price FROM rooms where typename = '$type'";
  $result = $conn->query($sql);
  if($result -> num_rows > 0){
    $row = $result->fetch_assoc();
    $available = $row['available'];
    $roomPrice = $row['price'];
    if($available < $number_of_rooms){
      $error = 'Not enough rooms available';
      $submit = 'Submission Failed';
      return;
    } else {
      $sql = "UPDATE rooms SET available = '$available' - '$number_of_rooms' WHERE typename = '$type'";
      $result = $conn->query($sql);
      if($result == true){
        $submit = 'submitted';
      } else {
        $submit = 'Submission Failed';
        $error = 'Database Error';
        return;
      }
    }
  } else {
    $error = 'Room type not found';
    $submit = 'Submission Failed';
    return;
  }
  $conn->close();

  $conn = mysqli_connect($server, $username, $password);
  if(!$conn){
    die('Connection Failed: '.mysqli_connect_error());
  }
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $nights = $_POST['number_of_nights'];
  $priceToBePid = calculatePrice($roomPrice, $number_of_rooms, $nights, $discount);
  $sql = "INSERT INTO `elite_peak`.`room_booking`(`name`, `email`, `phone`, `room_type`, `booked_number`, `nights`, `payment`, `timestamp`) VALUES ('$name','$email','$phone','$type', '$number_of_rooms', '$nights', '$priceToBePid' ,current_timestamp())";
  if($conn->query($sql) == true){
    $submit = 'submitted';
  }else {
    $submit = 'Submission Failed';
    $error = 'Database Error';
    return;
  }
  $conn->close();
}
if(isset($_POST['name'])){
  updateMyDB($submit, $error, $priceToBePid);
}
?>
<div class="container">
    <img src="/elite-peak/assets/images/5.jpg" class="contact-img">
</div>
<div class="container mt-5 mb-5 px-4">
  <div>
  <?php
    if($submit == 'submitted'){
      echo "<div class='alert alert-success' role='alert'>
      Your room has been booked You need to pay &#8377; $priceToBePid at the hotel.
      </div>";
    } else if ($submit == 'Submission Failed'){
      echo "<div class='alert alert-danger' role='alert'>
      Submission failed due to $error
      </div>";
    }
    ?>
  </div>
  <div id="warns">

  </div>
<form method="POST" action="index.php" onsubmit="fillCode()">
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
    <label for="exampleFormControlInput4">Number of Rooms to be booked</label>
    <input type="number" class="form-control" id="exampleFormControlInput4" placeholder="1" name="number_of_rooms" min="1" max="100" onchange="updatePrice()" oninput="updatePrice()" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput5">Number of Nights</label>
    <input type="number" class="form-control" id="exampleFormControlInput5" placeholder="1" name="number_of_nights" min="1" max="100" onchange="updatePrice()" oninput="updatePrice()" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Room Type</label>
    <select class="form-control" id="exampleFormControlSelect1" onchange="updatePrice()" name="type">
    <?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'elite_peak';

    $conn = new mysqli($server, $username, $password, $dbname);
    if($conn->connect_error){
      die('Connection Failed: '.$conn->connect_error);
    }
    $sql = "SELECT typename, price FROM rooms";
    $result = $conn->query($sql);
    if($result -> num_rows > 0){
      while($row = $result->fetch_assoc()){
        $type = $row['typename'];
        $price[$type] = $row['price'];
        echo "<option value=\"$type\">$type</option>";
      }
    } else {
      echo '<div class="alert alert-danger" role="alert">
      Your message has not been submitted.
      </div>';
    }
    $conn->close();
    $price_json = json_encode('{"price":'.json_encode($price).'}');
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput6">Do You Have a PromoCode</label>
    <input type="text" class="form-control" id="exampleFormControlInput6" placeholder="PROMO100" name="promo">
    <button type="button" class="btn btn-primary" onclick="checkPromo()">Apply Promo</button>
  </div>
  <div class="price mt-3">
    <h1 id="price_div">&#8377; </h1>
  </div>
  <button class="btn btn-primary mt-4 mb-5" type="submit">Book Now</button>
</form>
</div>
<script src="script.js"></script>
<script>
  var promocode = '';
  var disc = 0;
  var jsonData = JSON.parse(<?php echo $price_json; ?>);
  var selectElem = document.getElementById("exampleFormControlSelect1");
  document.getElementById("price_div").innerHTML = '&#8377; '+ jsonData.price[selectElem.value];
  function getPrice(perc, price){
    return price - ((perc/100)*price);
  }
  function updatePrice(){
    var priceh1 = document.getElementById('price_div');
    var nightSpend = document.getElementById('exampleFormControlInput5').value;
    var numberOfRooms = document.getElementById('exampleFormControlInput4').value;
    if(numberOfRooms == null || numberOfRooms == 0){
      numberOfRooms = 1;
    }
    if(nightSpend == null || nightSpend == 0){
      nightSpend = 1;
    }
    priceh1.innerHTML = '&#8377; ' + getPrice(disc, jsonData.price[selectElem.value] * numberOfRooms * nightSpend);
  }
  function checkPromo(){
    var promos = <?php
      $server = 'localhost';
      $username = 'root';
      $password = '';
      $dbname = 'elite_peak';

      $conn = new mysqli($server, $username, $password, $dbname);
      if($conn->connect_error){
        die('Connection Failed: '.$conn->connect_error);
      }
      $sql = "SELECT code, discount FROM promo_codes";
      $result = $conn->query($sql);
      if($result -> num_rows > 0){
        $promo_codes = array();
        while($row = $result->fetch_assoc()){
          $promo_codes[$row['code']] = $row['discount'];
        }
        echo json_encode($promo_codes);
      } else {
        echo '{}';
      }
      $conn->close();
    ?>;
    var promocodeDiv = document.getElementById('exampleFormControlInput6');
    promocode = promocodeDiv.value;
    if(promocode != null && promocode != undefined && promocode != '' && promos.hasOwnProperty(promocode)){
      disc = promos[promocode];
      updatePrice();
      mypromo = promocode;
      document.getElementById('warns').innerHTML = '<div class="alert alert-success" role="alert">Your Promo Code been Applied.</div>';
      promocodeDiv.value = '';
    } else {
      document.getElementById('warns').innerHTML = '<div class="alert alert-danger" role="alert">Your Promo Code is Invalid.</div>';
      promocodeDiv.value = '';
    }
  }
  function fillCode(){
    var promocodeDiv = document.getElementById('exampleFormControlInput6');
    promocodeDiv.value = mypromo;
    return true;
  }
</script>
