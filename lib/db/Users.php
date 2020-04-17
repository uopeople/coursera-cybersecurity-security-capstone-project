<?php


namespace lib\db;

use lib\model\User;
use lib\utils\Clock;
use lib\utils\ClockImpl;
use PDO;

/**
 * Access to database table 'users'
 */
class Users
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Clock
     */
    private $clock;

    public function __construct(PDO $pdo, ?Clock $clock = null)
    {
        $this->clock = $clock ?? new ClockImpl();
        $this->pdo = $pdo;
    }

    /**
     * Returns the user with the given user id. If no such user exists, this function returns null.
     *
     * @param int $userId
     *
     * @return User|null
     */
    public function loadUserById(int $userId): ?User
    {
        $sql = 'SELECT id, username, email, password, password_reset, login_ip, login_attempts, locked_time FROM users WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            // not found
            return null;
        }
        return $this->createUserEntityFromDbRecord($user);
    }

    /**
     * Returns the user with the given username. If no such user exists, this function returns null.
     *
     * Note that this can also be used to check if a username is "free", e.g. during registration.
     *
     * @param string $username
     *
     * @return User|null
     */
    public function loadUserByUsername(string $username): ?User
    {
        $sql = 'SELECT id, username, email, password, password_reset, login_ip, login_attempts, locked_time FROM users WHERE username = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            // not found
            return null;
        }
        return $this->createUserEntityFromDbRecord($user);
    }

    /**
     * Returns the user with the given email. If no such user exists, this function returns null.
     *
     * Note that this can also be used to check if an email address is "free", e.g. during registration.
     *
     * @param string $email
     *
     * @return User|null
     */
    public function loadUserByEmail(string $email): ?User
    {
        $sql = 'SELECT id, username, email, password, password_reset, login_ip, login_attempts, locked_time FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            // not found
            return null;
        }
        return $this->createUserEntityFromDbRecord($user);
    }

    /**
     * Locks the user (sets 'locked_time' to current timestamp).
     * The 'login_attempts' counter will be reset to 0.
     *
     * @param int $userId
     *
     * @throws \Exception
     */
    public function lockUser(int $userId)
    {
        $sql = 'UPDATE users SET login_attempts = 0, locked_time = ? WHERE id = ?';
        // Note: we generate the time via PHP, not SQL.
        // Times may differ (slightly) between SQL and PHP server.
        // When we decide if a user is allowed to login again, we use PHP to get the current time.
        // Because of this, it's more robust if we also use PHP when storing the 'locked_time'.
        $now = $this->clock->getCurrentTimestamp();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$now, $userId]);
        $updatedRows = $stmt->rowCount();
        if ($updatedRows !== 1) {
            throw new \Exception('Unexpected rowCount: ' . $updatedRows . ' were affected by the lockUser update statement');
        }
    }

    public function registerNewUser(string $username, string $email, string $cleartextPassword)
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';

        // Includes a salt.
        // PASSWORD_DEFAULT is currently bcrypt.
        // See https://www.php.net/manual/en/function.password-hash.php for details.
        $pwHash = password_hash($cleartextPassword, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$username, $email, $pwHash]);
            $cnt = $stmt->rowCount();
            if ($cnt < 1) {
                // probably username or email UNIQUE constraint violated?
                return false;
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * @param int $userId
     *
     * @throws \Exception
     */
    public function incrementLoginAttempts(int $userId)
    {
        $sql = 'UPDATE users SET login_attempts = login_attempts + 1 WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $updatedRows = $stmt->rowCount();
        if ($updatedRows !== 1) {
            throw new \Exception('Unexpected rowCount: ' . $updatedRows . ' were affected by the lockUser update statement');
        }
    }

    /**
     * This function loads the user with the given $username, then validates the $cleartextPassword against the password hash
     * stored for that user. If the password matches, the user is returned. Otherwise the login_attempts counter will be
     * incremented. If the counter was already at value 2 (i.e. this was the 3rd login attempt), then the user gets locked out
     * for some time.
     *
     * @param string $username
     * @param string $cleartextPassword
     *
     * @return User|null
     * @throws \Exception
     */
    public function loginByUsername(string $username, string $cleartextPassword): ?User
    {
        $user = $this->loadUserByUsername($username);
        if ($user === null) {
            // User does not exist.
            // To hide the information, whether or not the user exists, do a password_hash, to have similar response_time compared to the other
            // branch.
            password_hash($cleartextPassword, PASSWORD_DEFAULT); // ignore result
            return null;
        }
        $ok = password_verify($cleartextPassword, $user->getPassword());
        if ($ok) {
            return $user;
        } else {
            $loginAttempts = $user->getLoginAttempts() + 1;
            if ($loginAttempts >= 3) {
                $this->lockUser($user->getId());
            } else {
                $this->incrementLoginAttempts($user->getId());
            }
            return null;
        }
    }

    private function createUserEntityFromDbRecord(array $dbRecord): User
    {
        $pwReset = $dbRecord['password_reset'];
        if ($pwReset !== null) {
            $pwReset = boolval($pwReset);
        }
        $lockedTime = $dbRecord['locked_time'];
        if ($lockedTime !== null) {
            $lockedTime = intval($lockedTime);
        }
        return new User(
            intval($dbRecord['id']),
            $dbRecord['username'],
            $dbRecord['email'],
            $dbRecord['password'],
            $pwReset,
            $dbRecord['login_ip'],
            intval($dbRecord['login_attempts']),
            $lockedTime
        );
    }
}