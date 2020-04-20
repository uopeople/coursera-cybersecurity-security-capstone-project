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

        if (empty($email)) {
            // Email address is empty
            self::setError($values_ok, self::$emailErr, "Email address is required");
            $values_ok = FALSE;
        } else {
            // Save email to keep the value in the form
            self::$email = $email;

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Not a valid email address
                self::setError($values_ok, self::$emailErr, "Email address is not valid");
            } elseif(strlen($email) > 255) {
                // Email address is too long
                self::setError($values_ok, self::$emailErr,
                               "Email address cannot be longer than 255 characters");
            } elseif($dbUsers->loadUserByEmail($email)) {
                // Email address exists is database
                self::setError($values_ok, self::$emailErr, "Email address already exists");
            }
        }

        if (empty($password)) {
            // Password is empty
            self::setError($values_ok, self::$passErr, "Password is required");
        } elseif(strlen($password) > 255) {
            // Password is too long
            self::setError($values_ok, self::$passErr,
                           "Password cannot be longer than 255 characters");
        } else {
            $pass_hint = "<br /><br />" . "Hint: A good way to create a long complex password "
                         . "that is memorable is to select 2 to 3 common words, and separate them "
                         . "using different symbols. Alternatively, use a password manager.";
            if(strlen($password) < 10) {
                // Password is too short
                self::setError($values_ok, self::$passErr,
                               "Password is too short" . $pass_hint);
            } elseif(preg_match_all("/^[[:alpha:]]+$/", $password)) {
                // Password is made up of letters only
                self::setError($values_ok, self::$passErr,
                               "Weak password (contains letters only)" . $pass_hint);
            } elseif(preg_match_all("/^[[:digit:]]+$/", $password)) {
                // Password is made up of numbers only
                self::setError($values_ok, self::$passErr,
                               "Weak password (contains numbers only)" . $pass_hint);
            }
        }

        if (empty($password_repeat)) {
            // Password Repeat address is empty
            self::setError($values_ok, self::$passRptErr, "Please enter your password again");
        }

        if (!empty($password)
            and !empty($password_repeat)
            and $password != $password_repeat
        ) {
            // Passwords don't match
            self::setError($values_ok, self::$passRptErr, "Passwords don't match");
        }

        return $values_ok;
    }
}

?>
