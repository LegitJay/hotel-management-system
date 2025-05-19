<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $adminUsername = 'admin';
    $adminPassword = 'admin';
    
    if ($username === $adminUsername && $password === $adminPassword) {
        session_start();

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $adminUsername;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/adminLogin.css">
    
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form action="adminLogin.php" method="POST">
        
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
            
            <?php if (isset($_GET['error'])): ?>
                <p class="error-message">Invalid username or password</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>