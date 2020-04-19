<?php


namespace lib\service;


use lib\model\User;

class SessionManagerPhp implements SessionManager
{

    function regenerateId()
    {
        session_regenerate_id();
    }

    function getAuthenticatedUser(): ?User
    {
        if (!empty($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']) {
            return $_SESSION['user'] ?? null;
        }
        return null;
    }

    function setAuthenticatedUser(User $user)
    {
        $_SESSION['is_authenticated'] = true;
        $_SESSION['user'] = $user;
    }
}