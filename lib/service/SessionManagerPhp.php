<?php


namespace lib\service;

use lib\model\UserInfo;

class SessionManagerPhp implements SessionManager
{

    function regenerateId()
    {
        session_regenerate_id();
    }

    function getAuthenticatedUser(): ?UserInfo
    {
        if (!empty($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']) {
            return $_SESSION['user'] ?? null;
        }
        return null;
    }

    function setAuthenticatedUser(UserInfo $user)
    {
        $_SESSION['is_authenticated'] = true;

        // important: do NOT save the original $user object to the session. Instead, create a copy that
        // only contains id and username. (UserInfo may contain additional properties, added by subclasses).
        $_SESSION['user'] = new UserInfo($user->getId(), $user->getUsername());
    }
}