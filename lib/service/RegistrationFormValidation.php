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

        if (empty($username)) {
            self::$usernameErr = "Username is required";
            $values_ok = FALSE;
        } else {
            self::$username = $username;
        }

        if (empty($email)) {
            self::$emailErr = "Email address is required";
            $values_ok = FALSE;
        } else {
            self::$email = $email;
        }

        if (empty($password)) {
            self::$passErr = "Password is required";
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
