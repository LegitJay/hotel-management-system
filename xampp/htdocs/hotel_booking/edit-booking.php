<?php
session_start();
require_once "user.php";
$user = new User;

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$loginID = $_SESSION['id'];
$userData = $user->getUserInfoByLoginID($loginID);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guestName = $_POST['guest_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $arrivalD = $_POST['arrivalD'];
    $departureD = $_POST['departureD'];
    $adult = $_POST['adult'];
    $child = $_POST['child'];
    $specialRequest = $_POST['special_request'];
    
    if ($user->updateBooking($loginID, $guestName, $phone, $address,$specialRequest, $arrivalD, $departureD, $adult, $child)) {
        header("Location: finallyBooked.php");
        exit();
    } else {
        echo "There was an error updating your booking.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Booking - Casa Nova</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/edit.css">
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

<main class="edit-booking-container">
  <div class="booking-header">
    <h2>Edit Your Booking</h2>
    <p class="subtitle">Review and update your booking details</p>
  </div>
  
  <form method="POST" class="edit-booking-form">
    <div class="form-grid">
      <!-- Personal Information Section -->
      <div class="form-section">
        <h3 class="section-title">Personal Information</h3>
        <div class="form-group">
          <label for="guest_name">Full Name</label>
          <input type="text" name="guest_name" id="guest_name" value="<?= $userData['guest_name']; ?>" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" name="phone" id="phone" value="<?= $userData['phone']; ?>" required>
        </div>

        <div class="form-group">
          <label for="age">Age</label>
          <input type="text" name="age" id="age" value="<?= $userData['age']; ?>" required>
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" id="address" rows="2" required><?= $userData['address']; ?></textarea>
        </div>
      </div>

      <!-- Booking Details Section -->
      <div class="form-section">
        <h3 class="section-title">Booking Details</h3>
        <div class="form-group">
          <label for="arrivalD">Arrival Date</label>
          <input type="date" name="arrivalD" id="arrivalD" value="<?= $userData['arrivalD']; ?>" required>
        </div>

        <div class="form-group">
          <label for="departureD">Departure Date</label>
          <input type="date" name="departureD" id="departureD" value="<?= $userData['departureD']; ?>" required>
        </div>

        <div class="form-group">
          <label for="adult">Adults</label>
          <input type="number" name="adult" id="adult" min="1" value="<?= $userData['adult']; ?>" required>
        </div>

        <div class="form-group">
          <label for="child">Children</label>
          <input type="number" name="child" id="child" min="0" value="<?= $userData['child']; ?>" required>
        </div>
      </div>

      <!-- Additional Information Section -->
      <div class="form-section full-width">
        <h3 class="section-title">Additional Information</h3>
        <div class="form-group">
          <label for="payment">Payment Method</label>
          <select name="payment" id="payment" required>
            <option value="Cash" <?= ($userData['payment']);?>>Cash</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="special_request">Special Requests</label>
          <textarea name="special_request" id="special_request" rows="2"><?= $userData['special_request']; ?></textarea>
          <p class="helper-text">We'll do our best to accommodate your needs</p>
        </div>
      </div>
    </div>

    <button type="submit" class="submit-btn">Save Changes</button>
  </form>
</main>

</body>
</html>
