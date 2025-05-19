<?php
session_start ();
require_once "user.php";
$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->loginUser($email, $password)) {
        header("Location: homepage.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Casa Nova</title>
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="script/showPass.js" defer></script>
</head>
<body>

  <div class="login-container">
    <div class="left-panel">
      
    </div>

    <div class="right-panel">
      <div class="form-box">
        <h2>Welcome Back</h2>
        <p class="form-subtext">Log in to your Casa Nova account.</p>

        <form method="post">
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

          <label>Email:</label>
          <input type="email" name="email" required>

          <label>Password:</label>
          <div class="input-container">
            <input type="password" id="password" name="password">
            
              <label class="checkbox-container">
                <input type="checkbox" onclick="forPassword()">
                  Show Password
              </label>
          </div>

          <button type="submit" class="submit-btn">Login →</button>

          
          <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
