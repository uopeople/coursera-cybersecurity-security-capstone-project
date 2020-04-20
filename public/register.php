<?php
include __DIR__ . '/../setup.php';

use lib\db\Connection;
use lib\db\Users;
use lib\service\RegistrationFormValidation;

// Register user on submission of the form.
if(isset($_POST['register-submit'])) {
    if (RegistrationFormValidation::validateValues(
            $_POST["username"], $_POST["email"], $_POST["password"], $_POST["password-repeat"])) {
        $pdo = Connection::get_db_pdo();
        $users = new Users($pdo);
        $ok = $users->registerNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if ($ok) {
            header("Location: /login.php", true, 303);
            exit();
        } else {
            $registrationErr = "Registration failed. Please try again later.";
        }
    }
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
            <input class="input-field" type="text" name="username"
                   placeholder="Username"
                   value="<?php echo RegistrationFormValidation::$username;?>">
            <span class="error"><?php echo RegistrationFormValidation::$usernameErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" name="email"
                   placeholder="Email"
                   value="<?php echo RegistrationFormValidation::$email;?>">
            <span class="error"><?php echo RegistrationFormValidation::$emailErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password"
                   placeholder="Password">
            <span class="error"><?php echo RegistrationFormValidation::$passErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password-repeat"
                   placeholder="Repeat password">
            <span class="error"><?php echo RegistrationFormValidation::$passRptErr;?></span>
        </div>

        <div class="form-container">
            <button type="submit" name="register-submit">
                <i class="fas fa-user-plus icon"></i>Register
            </button>
        </div>

        <div class="form-container">
            <span id="registration-error">
                <?php echo $registrationErr;?>
            </span>
        </div>
    </form>

    <div id="main-links">
        <p id="link-home">
            <a href="index.php">
                <i class="fas fa-home icon"></i>Back to Home
            </a>
        </p>
        <p id="login">Log in</p>
    </div>
</body>

</html>
