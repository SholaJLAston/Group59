<?php
    include("header.html");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Apex Hardware</title>

    
    <link rel="stylesheet" href="Web_resources/StyleSheets/Main.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-subtitle">Sign up to start ordering tools and hardware online.</p>

            <form>
                <div class="form-group">
                    <label for="full_name">Full name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="e.g. Oswald Angadi">
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label for="address">Delivery address</label>
                    <input type="text" id="address" name="address" placeholder="House number, street, city, postcode">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password">
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirm password</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Repeat your password">
                </div>

                <button type="submit" class="primary-btn">Create account</button>

                <p class="auth-switch">
                    Already have an account?
                    <a href="login.php">Log in</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
