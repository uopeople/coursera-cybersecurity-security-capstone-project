<?php

include __DIR__ . '/../setup.php';

use lib\db\Connection;
use lib\db\Messages;
use lib\service\SessionManagerPhp;
use lib\service\SymmetricEncryption;

$sessMgr = new SessionManagerPhp();
$user = $sessMgr->getAuthenticatedUser();
if (!$user) {
    header('Location: /login.php?message=login_required', true, 303);
    exit();
}

try {
    $encryption = SymmetricEncryption::fromEnvironment();
    $message = new Messages(Connection::get_db_pdo(), $encryption);
    $boxMessages = $message->loadMessageViewsByRecipient($user->getId());
} catch (Exception $e) {
    echo 'Internal Server Error';
    http_response_code(500);
}

$pageTitle = 'Inbox';
$linkToInbox = false;
$linkToSentBox = true;

ob_start();
include TEMPLATE_DIR . '/pages/message-box.php';
$htmlContent = ob_get_clean();

include TEMPLATE_DIR . '/page.php';
