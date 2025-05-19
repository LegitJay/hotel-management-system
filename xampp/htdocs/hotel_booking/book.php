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
  $roomName = $_POST['room_name'];
  $price = $_POST['price'];

  if (isset($_SESSION['id'])) {

      if ($user->bookRoom($loginID, $roomName, $price)) {
        header("Location: completeBooking.php");
          exit();
      } else {
          echo "There was an error processing your booking.";
      }
  } else {
      echo "You must be logged in to book a room.";
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a room</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/book.css">
</head>
<body>
    <header>
        <nav>
            <div class="hotel-name">
                <h1>Casa Nova</h1>
            </div>
            <ul class="right-nav">
                <li><a href="logout.php" class="logout-btn">Log out</a></li>
            </ul>
        </nav>
    </header>

    <div class="booking-steps">
        <div class="step active">
            <div class="circle">1</div>
            <p>Choose Room</p>
        </div>

        <div class="line"></div>
        <div class="step">
            <div class="circle">2</div>
            <p>Guest Information</p>
        </div>

        <div class="line"></div>
        <div class="step">
            <div class="circle">3</div>
            <p>Review</p>
        </div>
    </div>

    <!-- Room Choose Section -->
    <section class="room-selection">
        <div class="room-card">
            <div class="room-image">
                <img src="css/images/room1.jpg" alt="Deluxe Room">
            </div>
            <div class="room-details">
                <h2>Deluxe Room</h2>
                <p class="price">₱3,500/night</p>
                <div class="other-desc"> 
                    <p class="check"> Complimentary breakfast buffet </p>
                    <p class="check"> In-room coffee and tea making facilities </p>
                    <p class="check"> Wireless internet connection </p>
                    <p class="check"> Roundtrip airport transfer </p>
                    <p class="check"> Use of swimming pool </p>
                    <p class="check"> Use of sauna </p>
                    <p class="check"> Use of fitness gym </p>
                </div>

            <form method="POST">
                <input type="hidden" name="room_name" value="Deluxe Room">
                <input type="hidden" name="price" value="3500">
                <button type="submit" class="book-btn">Book Now</button>
            </form> 

            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="css/images/room2.jpg" alt="Deluxe Twin">
            </div>
            <div class="room-details">
                <h2>Deluxe Twin</h2>
                <p class="price">₱5,700/night</p>
                <div class="other-desc"> 
                    <p class="check"> Complimentary breakfast buffet </p>
                    <p class="check"> In-room coffee and tea making facilities </p>
                    <p class="check"> Wireless internet connection </p>
                    <p class="check"> Roundtrip airport transfer </p>
                    <p class="check"> Use of swimming pool </p>
                    <p class="check"> Use of sauna </p>
                    <p class="check"> Use of fitness gym </p>
                </div>

            <form method="POST">
                <input type="hidden" name="room_name" value="Deluxe Twin">
                <input type="hidden" name="price" value="5700">
                <button type="submit" class="book-btn">Book Now</button>
            </form>

            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="css/images/room3.jpg" alt="Deluxe Twin Mayon View" class="room-image">
            </div>

            <div class="room-details">
                <h2>Deluxe Twin Mayon View</h2>

                <p class="price">₱6,000/night</p>

                <div class="other-desc"> 
                    <p class="check"> Complimentary breakfast buffet </p>
                    <p class="check"> In-room coffee and tea making facilities </p>
                    <p class="check"> Wireless internet connection </p>
                    <p class="check"> Roundtrip airport transfer </p>
                    <p class="check"> Use of swimming pool </p>
                    <p class="check"> Use of sauna </p>
                    <p class="check"> Use of fitness gym </p>
                </div>

            <form method="POST">
                <input type="hidden" name="room_name" value="Deluxe Twin Mayon View">
                <input type="hidden" name="price" value="6000">
                <button type="submit" class="book-btn">Book Now</button>
            </form>

            </div>
        </div>
    </section>
</body>
</html>
