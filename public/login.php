<?php
include __DIR__ . '/../setup.php';

if(isset($_GET['message'])) {
    $registration_message = "";
    if (htmlspecialchars($_GET['message']) == "registration_successful") {
        $registration_message = "<h2>Registration successful</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang=en>

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
    <i class="fas fa-comments icon"></i>
    <h1>Coursera Capstone Project Messaging System</h1>
</div>
<form method="post" action="login_post.php">
    <span><?php echo $registration_message;?></span>
    <h2>Login</h2>

    <div class="form-container">
        <i class="fa fa-user icon"></i>
        <input class="input-field" type="text" name="username" required
                placeholder="Username" />
    </div>

    <div class="form-container">
        <i class="fa fa-key icon"></i>
        <input class="input-field" type="password" name="password" required
                placeholder="Password" />
    </div>

    <div class="form-container">
        <button type="submit" name="submit">
            <i class="fas fa-sign-in-alt icon"></i>&nbsp;Login
        </button>
    </div>

    <div class="form-container">
        <a id="pass-reset" href="reset_password.php">Forgot your password?</a>
    </div>
</form>
<div id="main-links">
    <p id="link-home">
        <a href="index.php">
            <i class="fas fa-home icon"></i>&nbsp;Back to Home
        </a>
    </p>
    <p id="register">
        <a href="register.php">
            <i class="fas fa-user-plus icon"></i>&nbsp;Register
        </a>
    </p>
</div>
</body>

</html>
