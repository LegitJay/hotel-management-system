<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "user.php";
$user = new User();
$loginID = $_SESSION["id"] ?? null;


if (!$loginID) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $arrivalD = $_POST['arrivalD'];
  $departureD = $_POST['departureD'];
  $adult = $_POST['adult'];
  $child = $_POST['child'];

  if ($user->booking($loginID, $arrivalD, $departureD, $adult, $child)) {
    header("Location: book.php");
    exit();
  } else {
    $error = "You're not logged in or something went wrong.";
  }
}

$showBookingNav = false;
if ($user->isLoggedIn()) {
  $userData = $user->getUserInfoByLoginID($loginID);
  if (!empty($userData['arrivalD']) && !empty($userData['departureD'])) {
    $showBookingNav = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Casa Nova</title>
  <link rel="stylesheet" href="css/homepage.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script src="script/nav.js" defer></script>
  <script src="script/range.js" defer></script>
</head>
<body>

<div class="bg-slideshow"></div>

<header>
  <nav>
    <div class="hotel-name">
      <h1><a href="#home">Casa Nova</a></h1>
    </div>

    <ul class="center-nav">
      <li><a href="#home">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>

    <ul class="right-nav">
      <?php if ($showBookingNav): ?>
        <li><a href="finallyBooked.php" class="logout-btn">Booking</a></li>
      <?php endif; ?>
      <li><a href="logout.php" class="logout-btn">Log out</a></li>
    </ul>
  </nav>
</header>

<main>
  <section id="home">
    <div class="home-text">

      <?php if (isset($_SESSION['username'])): ?>
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
      <?php else: ?>
        <h2>Log In First</h2>
      <?php endif; ?>

      <div class="p">
        <p>Welcome to Casa Nova — your perfect getaway destination. Relax, recharge, and enjoy premium comfort and exceptional service during your stay.</p>
      </div>
    </div>

    <div class="ftr-nav">
      <form method="post" class="frm-book">
        <input type="text" name="arrivalD" id="arrivalD" placeholder="Arrival Date" onfocus="this.type='date'" required />
        <input type="text" name="departureD" id="departureD" placeholder="Departure Date" onfocus="this.type='date'" required />
        <input type="number" name="adult" placeholder="Adult" min="1" required />
        <input type="number" name="child" placeholder="Child (0-12 yrs)" min="0" required />
        <button type="submit">BOOK NOW</button>
      </form>
    </div>
  </section>

  <section id="about">
  <div class="about-container">
    <div class="about-content">
      <div class="section-header">
        <h2>Our Story</h2>
        <div class="divider">
          <span class="line"></span>
        </div>
      </div>

      <div class="about-grid">
        <div class="about-card">
          <div class="card-icon">🏛️</div>
          <h3>Heritage</h3>
          <p>Founded in 2025, Casa Nova has been providing exceptional hospitality, blending modern comfort with timeless elegance.</p>
        </div>

        <div class="about-card">
          <div class="card-icon">📍</div>
          <h3>Location</h3>
          <p>Nestled in the heart of the city, our hotel offers convenient access to business districts while providing a peaceful retreat from urban life.</p>
        </div>
        
        <div class="about-card">
          <div class="card-icon">🏆</div>
          <h3>Awards</h3>
          <p>Recipient of the prestigious Hospitality Excellence Award, recognized for our outstanding service and amenities.</p>
        </div>
      </div>
    </div>
  </div>
</section>

    <section id="services">

      <div class="services-container">
        <h2>Our Services</h2>

        <div class="services-grid">
          <div class="service-card">
            <div class="service-icon">🛎️</div>
            <h3>24/7 Service</h3>
            <p>Our dedicated staff is available round the clock to cater to your every need.</p>
          </div>

          <div class="service-card">
            <div class="service-icon">🍽️</div>
            <h3>Gourmet Dining</h3>
            <p>Experience world-class cuisine at our award-winning in-house restaurant.</p>
          </div>

          <div class="service-card">
            <div class="service-icon">🏊</div>
            <h3>Wellness Center</h3>
            <p>Relax in our spa or maintain your routine in our fully-equipped fitness center.</p>
          </div>

          <div class="service-card">
            <div class="service-icon">🚗</div>
            <h3>Transportation</h3>
            <p>Complimentary airport transfers and valet parking services available.</p>
          </div>
        </div>
      </div>
    </section>

    <footer id="contact">
      <div class="footer-container">

        <div class="footer-grid">
          <div class="footer-column">
            <h3>Contact Us</h3>
            <p>123 Washington Albay<br>Legazpi City, LC 1000</p>
            <p>Phone: +1 (555) 123-4567</p>
            <p>Email: info@casanova.com</p>
          </div>

          <div class="footer-column">
            <h3>Quick Links</h3>
            
            <div class="social-links">
              <a href="#home">Home</a>
              <a href="#about">About</a>
              <a href="#services">Services</a>
              <a href="register.php">Register</a>
            </div>
          </div>

          <div class="footer-column">
            <h3>Follow Us</h3>

            <div class="social-links">
              <a href="#">Facebook</a>
              <a href="#">Instagram</a>
              <a href="#">Twitter</a>
            </div>
          </div>
        </div>

        <div class="copyright">
          <p>&copy; 2025 Casa Nova. All rights reserved.</p>
        </div>

      </div>
    </footer>
  </main>

</body>
</html>
