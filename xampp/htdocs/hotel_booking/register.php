<?php
require_once "user.php";
$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->registerUser($username, $email, $password)) {
        header("Location: login.php");
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: Could not register user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration - Casa Nova</title>
  <link rel="stylesheet" href="css/register.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="script/showPass.js" defer></script>
</head>
<body>

  <div class="registration-container">
    <div class="left-panel">
      
    </div>

    <div class="right-panel">
      <div class="form-box">
        <h2>Create an Account</h2>
        <p class="form-subtext">Sign up to start booking your dream stay with Casa Nova.</p>

        <form method="post">
          <div class="form-row">
            <input type="text" name="username" placeholder="Username" required>
          </div>

          <div class="form-row">
            <input type="email" name="email" placeholder="Email" required>
          </div>

          <div class="form-row">
            <input type="password" name="password" id="password" placeholder="Password" required>

            <div class="checkbox-container">
                <input type="checkbox" onclick="forPassword()">
                  Show Password
            </div>
          </div>

          <button type="submit" class="register-btn">Register →</button>

          <p class="signin-link">Already have an account? <a href="login.php">Log in here</a></p>
        </form>
      </div>
    </div>
  </div>

</body>
</html>




