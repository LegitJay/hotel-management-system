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

$userData = $user->getUserInfoByLoginID($loginID);

if (!$userData) {
    echo 
    "<script>
        alert('Your booking has been rejected by the admin.');
        window.location.href = 'homepage.php';
    </script>";
    exit();
}


if (isset($_GET['delete'])) {
    if ($user->deleteBooking($loginID)) {
        header("Location: homepage.php"); 
        exit();
    } else {
        echo "There was an error deleting your booking.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Review Booking - Casa Nova</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/finallyBooked.css">
</head>
<body>

<header>
    <nav>
      <div class="hotel-name">
        <h1>Casa Nova</h1>
      </div>

      <ul class="right-nav">    
      <li><a href="logout.php" class="logout-btn">Log Out</a></li>
    </ul>
    </nav>
</header>

<div class="booking-steps">
      <div class="step">
        <div class="circle">1</div>
          <p>Choose Room</p>
      </div>

    <div class="line"></div>
      <div class="step">
        <div class="circle">2</div>
          <p>Guest Information</p>
      </div>

    <div class="line"></div>
      <div class="step active">
        <div class="circle">3</div>
          <p>Review</p>
      </div>
  </div>

<main class="review-container">
  <h2>Review Your Booking</h2>
  
  <div class="status">
  <span>Status: <strong><?= $userData['status'];?></strong></span>
  </div>

  <!-- Display Booking Details -->
  <section class="booking-info">
    <h3>Your Booking Details</h3>
    <p><strong>Check-in:</strong> <?= ($userData['arrivalD']); ?></p>
    <p><strong>Check-out:</strong> <?= ($userData['departureD']); ?></p>
    <p><strong>Number of Adults:</strong> <?= ($userData['adult']); ?></p>
    <p><strong>Number of Children:</strong> <?= ($userData['child']); ?></p>
  </section>

  <section class="room-details">
  <h3>Room Details</h3>
  <p><strong>Room Type:</strong> <?= ($userData['room_name'])?></p>
  <p><strong>Price:</strong> <?= ($userData['price'])?></p>
  </section>


  <section class="guest-info">
    <h3>Your Information</h3>
    <p><strong>Name:</strong> <?= ($userData['guest_name']); ?></p>
    <p><strong>Phone:</strong> <?= ($userData['phone']); ?></p>
    <p><strong>Age:</strong> <?= ($userData['age']); ?></p>
    <p><strong>Email:</strong> <?= ($userData['email']); ?></p>
    <p><strong>Address:</strong> <?= ($userData['address']); ?></p>
    <p><strong>Payment Method:</strong> <?= ($userData['payment'])?></p>
    <p><strong>Special Requests:</strong> <?= ($userData['special_request']); ?></p>
  </section>

 
  <section class="booking-actions">
    <a href="edit-booking.php" class="edit-btn">Edit Booking</a>
    <a href="?delete=true" class="delete-btn" onclick="return confirm('Are you sure you want to delete your booking?')">Delete Booking</a>
    <button class="confirm-btn" onclick="confirmBooking()">Confirm Booking</button>
  </section>

<script>
  function confirmBooking() {
    alert("Your booking has been processed!");
    window.location.href = "homepage.php";
  }
</script>

</main>
</body>
</html>
