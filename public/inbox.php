<?php
include __DIR__ . '/../setup.php';

use lib\db\Connection;
use lib\db\Messages;
use lib\service\SymmetricEncryption;

if (!isset($_SESSION['user'])) {
    header('Location: /login.php', true, 303);
    exit();
}

$user = $_SESSION["user"];
$userid = $user->getId();

try {
    $encryption = SymmetricEncryption::fromEnvironment();
    $message = new Messages(Connection::get_db_pdo(), $encryption);
    $boxMessages = $message->loadMessageViewsByRecipient($userid);
} catch (Exception $e) {
    echo 'Internal Server Error';
    http_response_code(500);
}

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1"/>
    
    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Inbox | Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
<div id="header">
    <h1>Inbox</h1>
</div>
<div class="container main">
    <div>
        <div>
            <a href="write_message.php">Create New Message</a> <!-- review write_message page address -->
        </div>
        <div>
            <h2>Messages:</h2>
            <?php include BASE_DIR . '/templates/messages_list.php'; ?>
        </div>
    </div>
</body>

</html>