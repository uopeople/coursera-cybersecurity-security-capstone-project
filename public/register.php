<?php
    include __DIR__ . '/../setup.php';

    function display()
    {
        echo "hello ".$_POST["email"];
    }

    if(isset($_POST['register-submit']))
    {
        display();
    }
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Register | Messaging System</title>

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

    <form id="register-form" action="register.php" method="post">
        <h2>Create a new account</h2>

        <div class="form-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="Username" name="username">
        </div>

        <div class="form-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" placeholder="Email" name="email">
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" placeholder="Password" name="password">
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" placeholder="Repeat password" name="password-repeat">
        </div>

        <div class="form-container">
            <button type="submit" name="register-submit"><i class="fas fa-user-plus icon"></i>Register</button>
        </div>
    </form>

    <div id="main-links">
        <p id="link-home">
            <a href="index.php">
                <i class="fas fa-home icon"></i>&nbsp;Back to Home
            </a>
        </p>
        <p id="login">Log in</p>
    </div>
</body>

</html>
