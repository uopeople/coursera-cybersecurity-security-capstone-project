<!DOCTYPE html>
<html lang=en>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <div id="header">
        <i class="fas fa-comments"></i>
        <h1>Coursera Capstone Project Messaging System</h1>
    </div>
    <form id="register-form" action="#" method="post">
        <h1>Create a new account</h1>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>
        <br>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>
        <br>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
        <br>

        <button type="submit" id="register-btn">Register</button>
    </form>
</body>

</html>
