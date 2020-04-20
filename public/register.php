<?php

include __DIR__ . '/../setup.php';

use lib\db\Connection;
use lib\db\Users;
use lib\service\RegistrationFormValidation;
use lib\service\SessionManagerPhp;

$sessMgr = new SessionManagerPhp();
if ($sessMgr->getAuthenticatedUser()) {
    // redirect to inbox
    header('Location: /inbox.php?message=already-authenticated', true, 303);
    return;
}

try {
    $pdo = Connection::get_db_pdo();
} catch (Exception $e) {
    echo htmlspecialchars('Failed to initialize the database connection');
    http_response_code(500);
    exit();
}
$users = new Users($pdo);
$validator = new RegistrationFormValidation($users);
$registrationErr = "";

// Register user on submission of the form.
if(isset($_POST['register-submit'])) {
    if ($validator->validateValues(
            $_POST["username"], $_POST["email"], $_POST["password"], $_POST["password-repeat"]))
    {
        $ok = $users->registerNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if ($ok) {
            header("Location: /login.php?message=registration_successful", true, 303);
            exit();
        } else {
            $registrationErr = "Registration failed due to a server error. Please try again later.";
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

        <?php
        if (empty($registrationErr)) {
        ?>

        <div class="form-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" name="username" required
                   placeholder="Username"
                   value="<?php echo htmlspecialchars($validator->getUsername());?>" />
            <span class="error"><?php echo htmlspecialchars($validator->getUsernameErr());?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" name="email" required
                   placeholder="Email"
                   value="<?php echo htmlspecialchars($validator->getEmail());?>" />
            <span class="error"><?php echo htmlspecialchars($validator->getEmailErr());?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password" required
                   placeholder="Password (minimum 10 characters, must contain both letters and numbers)" />
            <?php
            $passErr = htmlspecialchars($validator->getPassErr());
            if (!empty($passErr)) {
                $passErr = $passErr . "<br /><br />" . "Hint: A good way to create a long complex "
                           . "password that is memorable is to select 2 to 3 common words, and "
                           . "separate them using different symbols. Alternatively, use a password manager.";
            }
            ?>
            <span class="error"><?php echo $passErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password-repeat" required
                   placeholder="Repeat password" />
            <span class="error"><?php echo htmlspecialchars($validator->getPassRptErr());?></span>
        </div>

        <div class="form-container">
            <button type="submit" name="register-submit">
                <i class="fas fa-user-plus icon"></i>&nbsp;Register
            </button>
        </div>

        <?php
        } else {
        ?>

        <div class="form-container">
            <span id="registration-error">
                <?php echo htmlspecialchars($registrationErr);?>
            </span>
        </div>

        <?php
        }
        ?>
    </form>

    <div id="main-links">
        <p id="link-home">
            <a href="index.php">
                <i class="fas fa-home icon"></i>&nbsp;Back to Home
            </a>
        </p>
        <p id="login">
            <a href="login.php">
                <i class="fas fa-sign-in-alt icon"></i>&nbsp;Log in
            </a>
        </p>
    </div>
</body>

</html>
