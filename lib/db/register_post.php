<?php

namespace lib\db;

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
    $clean_data = trim($data);
    $clean_data = stripslashes($clean_data);
    $clean_data = htmlspecialchars($clean_data);
    return $clean_data;
}

class register_post {

    public static $username = "";
    public static $email = "";
    private static $pass = "";

    public static $usernameErr = "";
    public static $emailErr = "";
    public static $passErr = "";
    public static $passRptErr = "";

    /**
     * Register a new user.
     * Set error variables if issues are found.
     */
    public static function handle_registration() {
        if (empty($_POST["username"])) {
            self::$usernameErr = "Username is required";
        } else {
            self::$username = clean_input($_POST["username"]);
        }

        if (empty($_POST["email"])) {
            self::$emailErr = "Email address is required";
        } else {
            self::$email = clean_input($_POST["email"]);
        }

        if (empty($_POST["password"])) {
            self::$passErr = "Password is required";
        } else {
            self::$pass = clean_input($_POST["password"]);
        }

        if (!empty($_POST["password"])
            and !empty($_POST["password-repeat"])
            and $_POST["password"] != $_POST["password-repeat"]
        ) {
            self::$passRptErr = "Passwords don't match";
        }
    }
}

?>
