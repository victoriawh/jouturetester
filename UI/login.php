<?php
namespace App\UI;
require_once '../Authentication/Auth.php';

use App\Authentication\Auth;

session_start();

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailInput = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $passwordInput = $_POST['password'];

    if ($emailInput && $passwordInput) {
        $auth = new Auth();
        if ($auth->login($emailInput, $passwordInput)){
		header("Location: dashboard.php");
		exit();
        } else {
            $errorMessage = "Incorrect email or password. Please try again.";
        }
    } else {
        $errorMessage = "Please ensure both email and password are entered correctly.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouture Beauty Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header class="banner">
        <img src="../assets/images/jblogo.jpg" alt="Jouture Logo"> 
        <h1>Welcome to Jouture Beauty</h1>
    </header>

    <section class="login-container">
        <h1>Login</h1>
        <?php if (isset($errorMessage) && $errorMessage !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Log In</button>
        </form>
    </section>
</body>
</html>