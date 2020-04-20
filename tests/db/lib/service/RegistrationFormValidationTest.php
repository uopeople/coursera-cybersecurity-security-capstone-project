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
    private $dummyUser1Name = 'peter';
    private $dummyUser1Email = 'peter@example.com';
    private $dummyUser1Pass = 'very-secret';

    /**
     * Credentials for another dummy user
     */
    private $dummyUser2Name = 'testuser';
    private $dummyUser2Email = 'test@example.com';
    private $dummyUser2Pass = 'complex_*PASS//';

    /**
     * @before
     * @throws Exception
     */
    public function setupUserTableAndServices() {
        $this->pdo = Connection::get_db_pdo();
        $stmt = $this->pdo->prepare('DELETE FROM users;');
        $stmt->execute();

        $this->dbUsers = new Users($this->pdo);

        $this->dbUsers->registerNewUser($this->dummyUser1Name, $this->dummyUser1Email, $this->dummyUser1Pass);
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
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUser1Name, $this->dummyUser1Email,
                                                                $this->dummyUser1Pass, $this->dummyUser1Pass,
                                                                $this->dbUsers);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$usernameErr, "usernameErr should not be blank");
    }

    /**
     * Fail validation if the email address exists
     * @throws Exception
     */
    public function test_validateValues_returns_false_if_email_exists() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUser2Name, $this->dummyUser1Email,
                                                                $this->dummyUser1Pass, $this->dummyUser1Pass,
                                                                $this->dbUsers);

        $this->assertFalse($values_ok, 'Validation was expected to return false');
        $this->assertNotEmpty(RegistrationFormValidation::$emailErr, "usernameErr should not be blank");
    }

    /**
     * Success
     * @throws Exception
     */
    public function test_validateValues_returns_true_on_successful_validation() {
        $values_ok = RegistrationFormValidation::validateValues($this->dummyUser2Name, $this->dummyUser2Email,
                                                                $this->dummyUser2Pass, $this->dummyUser2Pass,
                                                                $this->dbUsers);

        $this->assertEmpty(RegistrationFormValidation::$usernameErr,
                           'usernameErr should be blank, not "' . RegistrationFormValidation::$usernameErr . '"');
        $this->assertEmpty(RegistrationFormValidation::$emailErr,
                           'emailErr should be blank, not "' . RegistrationFormValidation::$emailErr . '"');
        $this->assertEmpty(RegistrationFormValidation::$passErr,
                           'passErr should be blank, not "' . RegistrationFormValidation::$passErr . '"');
        $this->assertEmpty(RegistrationFormValidation::$passRptErr,
                           'passRptErr should be blank, not "' . RegistrationFormValidation::$passRptErr . '"');
        $this->assertTrue($values_ok, 'Validation was expected to return true');
    }
}
