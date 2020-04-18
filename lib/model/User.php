<?php


namespace lib\model;

use DateTime;

/**
 * A user entity
 *
 */
class User
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * The password hash (not: this is not the cleartext password, but an output of `password_hash`).
     *
     * @var string
     */
    private $password;

    /**
     * @var bool | null
     */
    private $passwordReset;

    /**
     * @var string | null
     */
    private $loginIp;

    /**
     * @var int
     */
    private $loginAttempts;

    /**
     * @var DateTime | null
     */
    private $lockedTime;

    /**
     * @param int      $id
     * @param string   $username
     * @param string   $email
     * @param string   $password
     * @param string   $loginIp
     * @param int      $loginAttempts
     * @param DateTime $lockedTime
     * @param bool     $passwordReset
     */
    public function __construct(
        int $id,
        string $username,
        string $email,
        string $password,
        ?bool $passwordReset,
        ?string $loginIp,
        int $loginAttempts,
        ?DateTime $lockedTime
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->passwordReset = $passwordReset;
        $this->loginIp = $loginIp;
        $this->loginAttempts = $loginAttempts;
        $this->lockedTime = $lockedTime;
        $this->passwordReset = $passwordReset;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool|null
     */
    public function getPasswordReset(): ?bool
    {
        return $this->passwordReset;
    }

    /**
     * @return string|null
     */
    public function getLoginIp(): ?string
    {
        return $this->loginIp;
    }

    /**
     * @return int
     */
    public function getLoginAttempts(): int
    {
        return $this->loginAttempts;
    }

    /**
     * The timestamp when the user was locked.
     *
     * @return DateTime|null
     */
    public function getLockedTime(): ?DateTime
    {
        return $this->lockedTime;
    }
}