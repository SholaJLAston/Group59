<?php
    include("header.html");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Log In - Apex Hardware</title>

    
    <link rel="stylesheet" href="../StyleSheets/index.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">Account Log In</h1>
            <p class="auth-subtitle">Log in to view your orders and manage your account.</p>

            <form>
                <div class="form-group">
                    <label for="login_email">Email address</label>
                    <input type="email" id="login_email" name="login_email" placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label for="login_password">Password</label>
                    <input type="password" id="login_password" name="login_password" placeholder="Enter your password">
                </div>

                <button type="submit" class="primary-btn">Log in</button>

                <p class="auth-switch">
                    Don’t have an account yet?
                    <a href="signup.php">Create one</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
