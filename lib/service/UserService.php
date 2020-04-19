<?php


namespace lib\service;


use lib\db\Users;
use lib\model\User;
use lib\utils\Clock;

class UserService
{

    /**
     * @var Users
     */
    private $dbUsers;

    /**
     * @var Clock
     */
    private $clock;

    /**
     * UserService constructor.
     *
     * @param Users $dbUsers
     * @param Clock $clock
     */
    public function __construct(Users $dbUsers, Clock $clock)
    {
        $this->dbUsers = $dbUsers;
        $this->clock = $clock;
    }

    /**
     * Checks if a given user is locked or not.
     *
     * See issue #12.
     *
     * @param User   $user                The user that should be checked. Can be loaded via `loadUserByUsername` or similar methods.
     * @param int    $lockDurationSeconds The time in seconds, after which a locked user is unlocked again.
     * @param string $requestIpAddr       The client ip address of the http request.
     *
     * @return bool
     */
    public function isUserLocked(User $user, int $lockDurationSeconds, string $requestIpAddr)
    {
        $now = $this->clock->getCurrentTimestamp();
        $userLockedSince = $user->getLockedTime();
        if ($userLockedSince === null) {
            // user is not locked
            return false;
        }
        if ($userLockedSince + $lockDurationSeconds < $now) {
            // user was locked, but lock duration has expired...
            return false;
        }
        // user is locked. But maybe, it's locked for the attacker's IP, and now, the real user wants to access the account.
        // (TODO need to think about the implications of this: The attacker can simply change his IP,
        //   then retry. On the other hand, this prevents the attacker from intentionally locking accounts (kind of "denial of service").
        $lockedFor = $user->getLoginIp();
        if ($lockedFor !== null && $requestIpAddr !== $lockedFor) {
            // Locked only for someone else...
            return false;
        }
        return true;
    }

}