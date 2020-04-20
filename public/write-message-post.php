<?php

use lib\db\Connection;
use lib\db\DbUtils;
use lib\db\Messages;
use lib\db\Users;
use lib\service\Logger;
use lib\service\SessionManagerPhp;
use lib\service\SymmetricEncryption;
use lib\utils\ClockImpl;

include __DIR__ . '/../setup.php';

$logger = Logger::getInstance();

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    echo 'Invalid method';
    http_response_code(405);
    return;
}


if (!isset($_POST['recipient'], $_POST['title'], $_POST['message-body'])) {
    echo '<h3>Form data is invalid</h3>';
    echo '<a href="write-message.php">Back to the form</a>';
    http_response_code(400);
    return;
}

// check authentication (user must be logged in)
$sessMgr = new SessionManagerPhp();
$sender = $sessMgr->getAuthenticatedUser();
if (!$sender) {
    echo 'Please login first...';
    http_response_code(403);
    return;
}

$recipientUsername = $_POST['recipient'];

try {
    $encryption = SymmetricEncryption::fromEnvironment();
    $pdo = Connection::get_db_pdo();
    $messages = new Messages($pdo, $encryption);
    $users = new Users($pdo);
    $clock = new ClockImpl();
    $recipient = $users->loadUserByUsername($recipientUsername);
    if (!$recipient) {
        echo '<h1>Bad request</h1><p>This user does not exist.</p>';
        echo '<p><a href="write-message.php">Back to the form</a></p>';
        http_response_code(400);
    }

    $ok = $messages->insertNewMessage(
        $sender->getId(),
        $recipient->getId(),
        $encryption->encrypt($_POST['title']),
        $encryption->encrypt($_POST['message-body']),
        $clock->getCurrentDateTimeUTC()->format(DbUtils::SQL_DATE_TIME_FORMAT),
        false
    );
    if (!$ok) {
        echo '<h1>Internal server error</h1><p>Something went wrong. The message could not be stored.</p>';
        echo '<p><a href="write-message.php">Back to the form</a></p>';
        http_response_code(500);
        return;
    }
    // success
    echo '<h1>Message has been sent successfully</h1>';
    echo '<a href="/inbox.php">To Inbox</a>';
    echo '<a href="/sent-messages.php">To sent messages</a>';
} catch (Exception $e) {
    echo 'Internal Server Error';
    $logger->logMessage(Logger::LEVEL_ERROR, 'failed', $e);
    http_response_code(500);
}


