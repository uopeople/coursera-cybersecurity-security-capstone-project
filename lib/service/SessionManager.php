<?php


namespace lib\service;

use lib\model\User;

interface SessionManager
{

    function regenerateId();

    function getAuthenticatedUser(): ?User;

    function setAuthenticatedUser(User $user);
}