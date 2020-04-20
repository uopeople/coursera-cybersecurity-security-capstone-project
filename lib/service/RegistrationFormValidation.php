<?php

namespace lib\service;

use lib\db\Users;

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
     * Set the value of the given field and ensure values_ok is false.
     *
     * @param bool $values_ok   Whether all values are ok (passed by reference)
     * @param field $field      The field to set (passed by reference)
     * @param string $value     The value to set
     */
    private function setError(bool &$values_ok, &$field, string $value) {
        $field = $value;
        $values_ok = FALSE;
    }

    /**
     * Ensure that all mandatory form values have been entered.
     *
     * @param string $username          The username entered by the user
     * @param string $email             The email address entered by the user
     * @param string $password          The password entered by the user
     * @param string $password_repeat   The repeated password entered by the user
     * @param Users  $dbUsers           Access to database table 'users'
     *
     * @return boolean Whether all values are ok.
     */
    public static function validateValues(
        string $username,
        string $email,
        string $password,
        string $password_repeat,
        Users $dbUsers
    ): bool {
        $values_ok = TRUE;

        if (empty($username)) {
            // Username is empty
            self::setError($values_ok, self::$usernameErr, "Username is required");
        } else {
            // Save username to keep the value in the form
            self::$username = $username;

            if(preg_match("/[^[:alnum:]\-_]/", $username)) {
                // Username contains invalid characters
                self::setError($values_ok, self::$usernameErr,
                               "Username must contain only: capital letters (A-Z), "
                               . "lowercase letters (a-z), numbers (0-9), underscore (_), dash (-)");
            } elseif(strlen($username) > 255) {
                // Username is too long
                self::setError($values_ok, self::$usernameErr,
                               "Username cannot be longer than 255 characters");
            } elseif($dbUsers->loadUserByUsername($username)) {
                // Username exists is database
                self::setError($values_ok, self::$usernameErr, "Username already exists");
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
