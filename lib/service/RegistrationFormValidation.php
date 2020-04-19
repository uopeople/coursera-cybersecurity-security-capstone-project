<?php

namespace lib\service;

class RegistrationFormValidation {

    public static $username = "";
    public static $email = "";

    public static $usernameErr = "";
    public static $emailErr = "";
    public static $passErr = "";
    public static $passRptErr = "";

    /**
     * Ensure that all mandatory form values have been entered.
     *
     * @return boolean Whether all values are ok.
     */
    public static function validate_values(): bool {
        $values_ok = TRUE;

        if (empty($_POST["username"])) {
            self::$usernameErr = "Username is required";
            $values_ok = FALSE;
        } else {
            self::$username = $_POST["username"];
        }

        if (empty($_POST["email"])) {
            self::$emailErr = "Email address is required";
            $values_ok = FALSE;
        } else {
            self::$email = $_POST["email"];
        }

        if (empty($_POST["password"])) {
            self::$passErr = "Password is required";
            $values_ok = FALSE;
        }

        if (!empty($_POST["password"])
            and !empty($_POST["password-repeat"])
            and $_POST["password"] != $_POST["password-repeat"]
        ) {
            self::$passRptErr = "Passwords don't match";
            $values_ok = FALSE;
        }

        return $values_ok;
    }
}

?>
