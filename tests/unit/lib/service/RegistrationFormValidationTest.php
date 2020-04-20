<?php


namespace tests\unit\lib\service;


use lib\service\RegistrationFormValidation;
use PHPUnit\Framework\TestCase;

class RegistrationFormValidationTest extends TestCase
{
    private static $TEST_USER = 'username';
    private static $TEST_EMAIL = 'email@example.com';
    private static $TEST_PASS = 'pass';

    /**
     * Fail validation if the username was not entered.
     */
    public function test_validateValues_returns_false_on_empty_username() {
        $values_ok = RegistrationFormValidation::validateValues("", "", "", "");

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");

        RegistrationFormValidation::$usernameErr = "";
    }

    /**
     * Fail validation if the email address was not entered.
     */
    public function test_validateValues_returns_false_on_empty_email() {
        $values_ok = RegistrationFormValidation::validateValues(self::$TEST_USER, "", "", "");

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$emailErr, "emailErr should not be blank");

        RegistrationFormValidation::$emailErr = "";
    }

    /**
     * Fail validation if the password was not entered.
     */
    public function test_validateValues_returns_false_on_empty_password() {
        $values_ok = RegistrationFormValidation::validateValues(self::$TEST_USER, self::$TEST_EMAIL, "", "");

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passErr, "passErr should not be blank");

        RegistrationFormValidation::$passErr = "";
    }

    /**
     * Fail validation if the password was not repeated.
     */
    public function test_validateValues_returns_false_on_empty_password_repeat() {
        $values_ok = RegistrationFormValidation::validateValues(self::$TEST_USER, self::$TEST_EMAIL,
                                                                self::$TEST_PASS, "");

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should not be blank");

        RegistrationFormValidation::$passRptErr = "";
    }

    /**
     * Fail validation if the password doesn't match the repeated password.
     */
    public function test_validateValues_returns_false_on_password_mismatch() {
        $values_ok = RegistrationFormValidation::validateValues(self::$TEST_USER, self::$TEST_EMAIL,
                                                                self::$TEST_PASS, "abc");

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should not be blank");

        RegistrationFormValidation::$passRptErr = "";
    }

    /**
     * Successful validation.
     */
    public function test_validateValues_returns_true_on_successful_validation() {
        $values_ok = RegistrationFormValidation::validateValues(self::$TEST_USER, self::$TEST_EMAIL,
                                                                self::$TEST_PASS, self::$TEST_PASS);

        $this->assertTrue($values_ok, 'Validation was expected to return true');
        $this->assertEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$emailErr, "emailErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passErr, "passErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should be blank");
    }
}
