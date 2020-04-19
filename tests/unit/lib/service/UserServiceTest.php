<?php


namespace tests\unit\lib\service;


use lib\db\Users;
use lib\model\User;
use lib\service\UserService;
use lib\utils\Clock;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{

    public function test_isUserLocked_returns_true_if_locking_duration_has_not_expired_yet_and_ip_matches()
    {
        $now = 100; // current time: 100 seconds after beginning of time

        $clock = $this->createStub(Clock::class);
        $clock->method('getCurrentTimestamp')->willReturn($now);

        // system under test
        $usersDao = $this->createStub(Users::class);
        $sut = new UserService($usersDao, $clock);

        // the time when the user was locked.
        $lockedTime = 50;
        $userIp = '1.2.3.4';
        $user = new User(1, 'username', 'email@example.com', 'pass', null, $userIp, 0, $lockedTime);

        // in our test, after a user is locked, her cannot login for the next 200 seconds...
        $lockDuration = 200;
        $this->assertTrue(
            $sut->isUserLocked($user, $lockDuration, $userIp)
        );
    }
}