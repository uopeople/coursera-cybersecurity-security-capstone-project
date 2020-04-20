<?php


namespace tests\unit\lib\service;


use lib\service\RegistrationFormValidation;
use lib\db\Users;
use PHPUnit\Framework\TestCase;

class RegistrationFormValidationTest extends TestCase
{
    /**
     * @var Stub
     */
    private $users;

    /**
     * Credentials for a dummy user
     */
    private $dummyUserName = 'username';
    private $dummyUserEmail = 'email@example.com';
    private $dummyUserPass = 'pass';

    /**
     * Create a stub of the Users class.
     * @before
     */
    public function createUsersStub() {
        $this->$users = $this->createStub(Users::class);
    }

    /**
     * Reset all error message fields of RegistrationFormValidation.
     * @after
     */
    public function resetErrorMessages() {
        RegistrationFormValidation::$usernameErr = "";
        RegistrationFormValidation::$emailErr = "";
        RegistrationFormValidation::$passErr = "";
        RegistrationFormValidation::$passRptErr = "";
    }

    /**
     * Fail validation if the username was not entered.
     */
    public function test_validateValues_returns_false_on_empty_username() {
        $values_ok = RegistrationFormValidation::validateValues("", "", "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");
    }

    /**
     * Fail validation if the username was too long.
     */
    public function test_validateValues_returns_false_on_long_username() {
        $values_ok = RegistrationFormValidation::validateValues(str_repeat("x", 256), "", "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");
    }

    /**
     * Fail validation if the username contained invalid characters.
     */
    public function test_validateValues_returns_false_on_username_with_invalid_characters() {
        $values_ok = RegistrationFormValidation::validateValues("username=5", "", "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");
    }

    /**
     * Fail validation if the email address was not entered.
     */
    public function test_validateValues_returns_false_on_empty_email() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, "", "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$emailErr, "emailErr should not be blank");
    }

    /**
     * Fail validation if the email address was too long.
     */
    public function test_validateValues_returns_false_on_long_email() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, str_repeat("x", 256),
                                                                "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$emailErr, "emailErr should not be blank");
    }

    /**
     * Generate a list of invalid email addresses for unit testing.
     */
    public function providerInvalidEmailAddress() {
        return array(
            ["email@example"],
            ["email@-example.com"],
            ["email@example..com"],
            ["email.example.com"],
            ["email.@example.com"],
            ["email..email@example.com"],
            [".email@example.com"],
            ["email@example@example.com"],
            ["email@111.222.333.44444"],
            ["@example.com"],
            ["plainaddress"],
            ["email@example.com (Joe Smith)"],
            ["Joe Smith <email@example.com>"],
            ["#@%^%#$@#$@#.com"],
            ["あいうえお@example.com"],
            ["Abc..123@example.com"],
            ['very.unusual."@".unusual.com@example.com\''],
            ['very."(),:;<>[]".VERY."very@\\ "very".unusual@strange.example.com'],
        );
    }
    /**
     * Fail validation if the email address was invalid.
     * @dataProvider providerInvalidEmailAddress
     */
    public function test_validateValues_returns_false_on_invalid_email(string $testEmail) {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $testEmail,
                                                                "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$emailErr, "emailErr should not be blank");
    }

    /**
     * Fail validation if the password was not entered.
     */
    public function test_validateValues_returns_false_on_empty_password() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $this->dummyUserEmail,
                                                                "", "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passErr, "passErr should not be blank");
    }

    /**
     * Fail validation if the password was too long.
     */
    public function test_validateValues_returns_false_on_long_password() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $this->dummyUserEmail,
                                                                str_repeat("x", 256), "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passErr, "passErr should not be blank");
    }

    /**
     * Fail validation if the password was not repeated.
     */
    public function test_validateValues_returns_false_on_empty_password_repeat() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $this->dummyUserEmail,
                                                                $this->dummyUserPass, "", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should not be blank");
    }

    /**
     * Fail validation if the password doesn't match the repeated password.
     */
    public function test_validateValues_returns_false_on_password_mismatch() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $this->dummyUserEmail,
                                                                $this->dummyUserPass, "abc", $this->$users);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should not be blank");
    }

    /**
     * Generate a list of valid email addresses for unit testing.
     */
    public function providerValidEmailAddress() {
        return array(
            ["email@example.com"],
            ["firstname.lastname@example.com"],
            ["email@subdomain.example.com"],
            ["firstname+lastname@example.com"],
            ["email@[123.123.123.123]"],
            ['"email"@example.com'],
            ["1234567890@example.com"],
            ["email@example-one.com"],
            ["_______@example.com"],
            ["email@example.name"],
            ["email@example.museum"],
            ["email@example.co.jp"],
            ["firstname-lastname@example.com"],
            ['much."more\ unusual"@example.com'],
        );
    }
    /**
     * Successful validation.
     * @dataProvider providerValidEmailAddress
     */
    public function test_validateValues_returns_true_on_successful_validation(string $testEmail) {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $testEmail,
                                                                $this->dummyUserPass, $this->dummyUserPass,
                                                                $this->$users);

        $this->assertTrue($values_ok, 'Validation was expected to return true');
        $this->assertEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$emailErr, "emailErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passErr, "passErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should be blank");
    }
}
