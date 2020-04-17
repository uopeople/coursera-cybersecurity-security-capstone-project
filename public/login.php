<!DOCTYPE html>
<html lang=en>

<?php
include __DIR__ . '/../setup.php';
?>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1"/>

    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Login | Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
<div id="header">
    <h1>Login</h1>
</div>
<div class="container main">
    <form method="post" action="login_post.php">
        <div>
            <div>
                <label>
                    <span>Username</span><br>
                    <input type="text" name="username" required>
                </label>
            </div>
            <div>
                <label>
                    <span>Password</span><br>
                    <input type="password" name="password" required>
                </label>
            </div>
            <div>
                <button type="submit" name="submit"><i class="fas fa-sign-in-alt"></i>&nbsp;Login</button>
            </div>
        </div>
    </form>
    <div>
        <a href="reset_password.php">Forgot your password?</a>
    </div>
</div>
<div id="main-links">
    <p id="link-home"><a href="index.php">Back to Startpage</a></p>
    <p id="register">Register</p>
</div>
</body>

</html>
