<?php


namespace lib\service;

use lib\db\Users;

class LoginService
{

    /**
     * How long a user gets locked after some failed login attempts
     *
     * @var int
     */
    private $lockDurationSeconds;

    /**
     * @var int
     */
    private $maxNumOfLoginAttempts;

    /**
     * @var Users
     */
    private $dbUsers;

    /**
     * @param Users $dbUsers
     * @param int   $lockDurationSeconds
     * @param int   $maxNumOfLoginAttempts
     */
    public function __construct(Users $dbUsers, int $lockDurationSeconds = 120, int $maxNumOfLoginAttempts = 5)
    {
        $this->dbUsers = $dbUsers;
        $this->lockDurationSeconds = $lockDurationSeconds;
        $this->maxNumOfLoginAttempts = $maxNumOfLoginAttempts;
    }

    /**
     * // TODO test this with a database "integration" test, after #22 got merged.
     *
     * This function loads the user with the given $username, then validates the $cleartextPassword against the password hash
     * stored for that user. If the password matches, the user is returned.
     * Otherwise the login_attempts counter will be incremented for that user's IP address.
     * If the counter exceeds the max number of allowed login attempts, then the user gets locked for some time.
     *
     * @param string $username
     * @param string $cleartextPassword
     * @param string $requestIp
     *
     * @return LoginResult
     * @throws \Exception
     */
    public function tryLogin(string $username, string $cleartextPassword, string $requestIp): LoginResult
    {
        $user = $this->dbUsers->loadUserByUsername($username);
        if ($user === null) {
            // User does not exist.
            // To hide the information, whether or not the user exists, do a password_hash, to have similar response_time compared to the other
            // branch.
            password_hash($cleartextPassword, PASSWORD_DEFAULT); // ignore result
            return LoginResult::createWrongCrendentialsResult();
        }
        // TODO after merging #22: provide $requestIp
        if ($this->dbUsers->isUserLocked($user, $this->lockDurationSeconds)) {
            return LoginResult::createUserLockedResult();
        }
        $pwHash = $user->getPassword();
        $ok = password_verify($cleartextPassword, $pwHash);
        if ($ok) {
            $this->dbUsers->resetLoginAttemptsCounter($user->getId());
            // best practice is to give the session a new id after successful login
            session_regenerate_id();
            return LoginResult::createSuccessfulResult($user);
        }

        $loginAttempts = $user->getLoginAttempts() + 1;
        if ($loginAttempts >= $this->maxNumOfLoginAttempts) {
            // Note: even if the user gets locked now, *this* request was denied because of wrong credentials, not locked user.
            // (The user sees the "you're locked out" message after the next attempt)
            $this->dbUsers->lockUser($user->getId(), $requestIp);
        } else {
            $this->dbUsers->incrementLoginAttempts($user->getId(), $requestIp);
        }
        return LoginResult::createWrongCrendentialsResult();
    }

}