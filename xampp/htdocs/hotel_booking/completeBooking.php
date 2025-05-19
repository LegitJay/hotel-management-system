<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "user.php";
$user = new User;
$loginID = $_SESSION["id"] ?? null;


if (!$loginID) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['guest_name'], $_POST['phone'], $_POST['age'], $_POST['payment'], $_POST['address'], $_POST['special_request'])) {
      $guestName = $_POST['guest_name'];
      $phone = $_POST['phone'];
      $age = $_POST['age'];
      $address = $_POST['address'];
      $payment = $_POST['payment'];
      $specialRequest = $_POST['special_request'];

      if ($user->completion($loginID, $guestName, $phone, $age, $address, $payment, $specialRequest)) {
          header("Location: finallyBooked.php");
          exit();
      } else {
          echo "An error occurred while processing your booking.";
      }
  } else {
      echo "Please fill in all the required fields.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guest Information - Casa Nova</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/completeBooking.css">
</head>
<body>

<header>
  <nav>
    <div class="hotel-name">
      <h1>Casa Nova</h1>
    </div>

    <ul class="right-nav">
      <li><a href="logout.php" class="log-btn">Log out</a></li>
    </ul>
  </nav>
</header>

<div class="booking-steps">
      <div class="step">
        <div class="circle">1</div>
          <a href=""><p>Choose Room</p></a>
      </div>

    <div class="line"></div>
      <div class="step active">
        <div class="circle">2</div>
          <p>Guest Information</p>
      </div>

    <div class="line"></div>
      <div class="step">
        <div class="circle">3</div>
          <p>Review</p>
      </div>
  </div>

  <main>
    <div class="guest-container">
      <div class="form-header">
        <h2>Guest Information</h2>
        <p>Please provide your details to complete your booking</p>
      </div>

      <form method="POST">
        <div class="form-grid">
          <div class="form-group">
            <label for="guest_name">Full Name</label>
            <input type="text" name="guest_name" id="guest_name" placeholder="Enter your full name" required>
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" placeholder="+63 912 345 6789" required>
          </div>

          <div class="form-group">
            <label for="age">Age</label>
            <input type="text" name="age" id="phone" placeholder="21" required>
          </div>

          <div class="form-group">
            <label for="payment-mtd">Payment Method</label>
            <select name="payment" id="payment" required>
              <option value="" disabled selected>Select payment method</option>
              <option value="cash">Cash</option>
            </select>
          </div>

          <div class="form-group full-width">
            <label for="address">Address</label>
            <textarea name="address" id="address" rows="2" placeholder="Your complete address" required></textarea>
          </div>

          <div class="form-group full-width">
            <label for="special_request">Special Requests (Optional)</label>
            <textarea name="special_request" id="special_request" rows="2" placeholder="Any special requests or notes"></textarea>
            <p class="helper-text">We'll do our best to accommodate your requests</p>
          </div>
        </div>

        <button type="submit" class="submit-btn">Continue to Review</button>
      </form>
    </div>
  </main>

</body>
</html>
