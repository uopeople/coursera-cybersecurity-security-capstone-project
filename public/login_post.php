<?php

use lib\db\Connection;
use lib\db\Users;
use lib\service\IpUtils;
use lib\service\Logger;
use lib\service\LoginService;

include __DIR__ . '/../setup.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    echo 'Invalid method';
    http_response_code(405);
    return;
}

try {
    $pdo = Connection::get_db_pdo();
    $users = new Users($pdo);
    $loginService = new LoginService($users);
    $result = $loginService->tryLogin($_POST['username'], $_POST['password'], IpUtils::getIp());
    if ($result->isSuccessful()) {
        header('Location: /inbox.php', true, 303);
    } else if ($result->isLocked()) {
        $message = 'Your Account has been locked, because of too many failed login attempts. Please wait 2 minute';
        include BASE_DIR . '/templates/login_failed.php';
        http_response_code(200);
    } else if ($result->isWrongCredentialsProvided()) {
        $message = 'Invalid credentials provided';
        include BASE_DIR . '/templates/login_failed.php';
        http_response_code(200);
    }
} catch (Exception $e) {
    Logger::getInstance()->logMessage(Logger::LEVEL_ERROR, 'technical error during login', $e);
    echo 'Internal server error';
    http_response_code(500);
}

