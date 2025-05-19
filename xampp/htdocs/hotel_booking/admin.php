<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "user.php";
$user = new User;

$allBookings = $user->getAllBookingsWithDetails();

if (isset($_GET['approve'])) {
    $user->updateBookingStatus($_GET['approve'], 'Approved');
    header("Location: admin.php");
    exit();
}

if (isset($_GET['delete'])) {
    $loginID = intval($_GET['delete']);
    if ($user->deleteBooking($loginID)) {
        header("Location: admin.php"); 
        exit();
    } else {
        echo "There was an error deleting the user's booking.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Casa Nova</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<header>
  <nav>
    <div class="hotel-name">
      <h1>Casa Nova</h1>
    </div>
    <ul class="right-nav">
      <li><a href="adminLogout.php" class="logout-btn">Log Out</a></li>
    </ul>
  </nav>
</header>

<main class="review-container">
  <h2>Bookings Management</h2>

  <?php if (!empty($allBookings)): ?>
    <?php 
      $currentUser = null;
      foreach ($allBookings as $booking): 
        if ($booking['loginID'] !== $currentUser):
          $currentUser = $booking['loginID'];
    ?>
          <div class="user-booking">
            <div class="user-header">
              <h3>Status: <strong><?= $booking['status'];?></strong> </h3> 
              <h2><?= ($booking['guest_name']);  ?> <small>/ guest name</small></h2> 
              <p>from user ID: <strong><?= ($booking['loginID']); ?></strong> |
               from username: <strong><?=  ($booking['username']); ?> </strong></p>
            </div>
            
            <div class="booking-grid">
              <div class="booking-section">
                <h3>Booking Details</h3>
                <div class="detail-row">
                  <span class="detail-label">Check-in:</span>
                  <span class="detail-value"><?= ($booking['arrivalD']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Check-out:</span>
                  <span class="detail-value"><?= ($booking['departureD']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Guests:</span>
                  <span class="detail-value"><?= ($booking['adult']); ?> adults, <?= ($booking['child']); ?> children</span>
                </div>
              </div>
              
              <div class="booking-section">
                <h3>Room Details</h3>
                <div class="detail-row">
                  <span class="detail-label">Room Type:</span>
                  <span class="detail-value"><?= ($booking['room_name']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Price:</span>
                  <span class="detail-value"><?= ($booking['price']); ?></span>
                </div>
              </div>
              
              <div class="booking-section">
                <h3>Guest Information</h3>
                
                <div class="detail-row">
                  <span class="detail-label">Phone:</span>
                  <span class="detail-value"><?= ($booking['phone']); ?></span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Age:</span>
                  <span class="detail-value"><?= ($booking['age']); ?></span>
                </div>

                <div class="detail-row">
                  <span class="detail-label">Email:</span>
                  <span class="detail-value"> <?= ($booking['email']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Address:</span>
                  <span class="detail-value"><?= ($booking['address']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Payment:</span>
                  <span class="detail-value"><?= ($booking['payment']); ?></span>
                </div>
                <div class="detail-row">
                  <span class="detail-label">Requests:</span>
                  <span class="detail-value"><?= ($booking['special_request'] ?: 'None'); ?></span>
                </div>
              </div>
            </div>
            
            <div class="booking-actions">
              <a href="admin.php?approve=<?= $booking['loginID']?>" class="confirm-btn">Approve</a>
              <a href="?delete=<?= $booking['loginID']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete all bookings from this user?')">Reject</a>
            </div>
          </div>
    <?php
        endif;
      endforeach; 
    ?>
  <?php else: ?>
    <div class="no-bookings">
      <p>No bookings found.</p>
    </div>
  <?php endif; ?>

</main>

<script>
  function confirmBooking() {
    alert('Booking confirmed!');
  }
</script>
</body>
</html>