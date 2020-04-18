<?php
    include __DIR__ . '/../setup.php';

    // Validate form values on POST
    if(isset($_POST['register-submit']))
    {
        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = clean_input($_POST["username"]);
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email address is required";
        } else {
            $email = clean_input($_POST["email"]);
        }

        if (empty($_POST["password"])) {
            $passErr = "Password is required";
        } else {
            $pass = clean_input($_POST["password"]);
        }

        if (!empty($_POST["password"])
            and !empty($_POST["password-repeat"])
            and $_POST["password"] != $_POST["password-repeat"]
        ) {
            $passRptErr = "Passwords don't match";
        }
    }

    /**
     * Ensure that user-entered data is safe for processing by:
     *      - Removing whitespace from the beginning and end of the string
     *      - Removing backslashes to unquote the string
     *      - Converting special characters to HTML entities
     *
     * @param string $data The data entered by the user in a form field.
     *
     * @return string A safe version of the user-entered data.
     */
    function clean_input(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
                   placeholder="Username" value="<?php echo $username;?>">
            <span class="error"><?php echo $usernameErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" name="email"
                   placeholder="Email" value="<?php echo $email;?>">
            <span class="error"><?php echo $emailErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password"
                   placeholder="Password">
            <span class="error"><?php echo $passErr;?></span>
        </div>

        <div class="form-container">
            <i class="fa fa-key icon"></i>
            <input class="input-field" type="password" name="password-repeat"
                   placeholder="Repeat password">
            <span class="error"><?php echo $passRptErr;?></span>
        </div>

        <div class="form-container">
            <button type="submit" name="register-submit">
                <i class="fas fa-user-plus icon"></i>Register
            </button>
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
