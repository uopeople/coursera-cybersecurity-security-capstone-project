<?php

namespace lib\service;

class RegistrationFormValidation {

    /**
     * The username and email will be remembered if validation fails.
     */
    public static $username = "";
    public static $email = "";

    /**
     * The error messages to show for each field if validation fails.
     */
    public static $usernameErr = "";
    public static $emailErr = "";
    public static $passErr = "";
    public static $passRptErr = "";

    /**
     * Ensure that all mandatory form values have been entered.
     *
     * @param string $username          The username entered by the user
     * @param string $email             The email address entered by the user
     * @param string $password          The password entered by the user
     * @param string $password_repeat   The repeated password entered by the user
     *
     * @return boolean Whether all values are ok.
     */
    public static function validateValues(
        string $username,
        string $email,
        string $password,
        string $password_repeat
    ): bool {
        $values_ok = TRUE;

        // Check for empty username
        if (empty($username)) {
            self::$usernameErr = "Username is required";
            $values_ok = FALSE;
        } else {
            self::$username = $username;
            // Check if username contains invalid characters
            if(preg_match("/[^[:alnum:]\-_]/", $username)) {
                self::$usernameErr = "Username must contain only: capital letters, lowercase letters, numbers, _, -";
                $values_ok = FALSE;
            // Check if username is too long
            } elseif(strlen($username) > 255) {
                self::$usernameErr = "Username cannot be longer than 255 characters";
                $values_ok = FALSE;
            }
        }

        // Check for empty email address
        if (empty($email)) {
            self::$emailErr = "Email address is required";
            $values_ok = FALSE;
        } else {
            self::$email = $email;
            // Check if this is a valid email address
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                self::$emailErr = "Email address is not valid";
                $values_ok = FALSE;
            // Check if email is too long
            } elseif(strlen($email) > 255) {
                self::$emailErr = "Email address cannot be longer than 255 characters";
                $values_ok = FALSE;
            }
        }

        if (empty($password)) {
            self::$passErr = "Password is required";
            $values_ok = FALSE;
        } elseif(strlen($password) > 255) {
            // Check if password is too long
            self::$passErr = "Password cannot be longer than 255 characters";
            $values_ok = FALSE;
        }

        if (empty($password_repeat)) {
            self::$passRptErr = "Please enter your password again";
            $values_ok = FALSE;
        }

        if (!empty($password)
            and !empty($password_repeat)
            and $password != $password_repeat
        ) {
            self::$passRptErr = "Passwords don't match";
            $values_ok = FALSE;
        }

        return $values_ok;
    }
}

?>
