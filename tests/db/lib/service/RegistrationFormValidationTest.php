<?php


namespace tests\db\lib\service;


use Exception;
use lib\db\Connection;
use lib\db\Users;
use lib\service\RegistrationFormValidation;
use PHPUnit\Framework\TestCase;

class RegistrationFormValidationTest extends TestCase
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Users
     */
    private $dbUsers;

    /**
     * Credentials for a dummy user
     */
    private $dummyUserName = 'peter';
    private $dummyUserEmail = 'peter@example.com';
    private $dummyUserPass = 'very-secret';

    /**
     * @before
     * @throws Exception
     */
    public function setupUserTableAndServices() {
        $this->pdo = Connection::get_db_pdo();
        $stmt = $this->pdo->prepare('DELETE FROM users;');
        $stmt->execute();

        $this->dbUsers = new Users($this->pdo);

        $this->dbUsers->registerNewUser($this->dummyUserName, $this->dummyUserEmail, $this->dummyUserPass);
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
     * Fail validation if the username exists
     * @throws Exception
     */
    public function test_validateValues_returns_false_if_username_exists() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUserName, $this->dummyUserEmail,
                                                                $this->dummyUserPass, $this->dummyUserPass,
                                                                $this->dbUsers);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");
    }

    /**
     * Success
     * @throws Exception
     */
    public function test_validateValues_returns_true_on_successful_validation() {
        $values_ok = RegistrationFormValidation::validateValues("testuser", "test@example.com",
                                                                "pass", "pass",
                                                                $this->dbUsers);

        $this->assertTrue($values_ok, 'Validation was expected to return true');
        $this->assertEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$emailErr, "emailErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passErr, "passErr should be blank");
        $this->assertEmpty(RegistrationFormValidation::$passRptErr, "passRptErr should be blank");
    }
}
