<?php
include __DIR__ . '/../setup.php';

use lib\db\Messages;
use lib\service\SymmetricEncryption;

if (!isset($_SESSION['user'])) {
    header('Location: /login.php', true, 303);
    exit();
}

$user = $_SESSION["user"];
$userid = $user->getId();
$message = new Messages();
$boxMessages = $message->loadMessagesByRecipient($userid);

try {
    $encryption = SymmetricEncryption::fromEnvironment();
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
        <table>
            <tr>
                <th>Id</th> <!-- TODO do we want to show the id? -->
                <th>Sender</th>
                <th>Recipient</th>
                <th>Title</th>
                <th>Message</th>
                <th>Date</th>
                <th>Read</th>
            </tr>
            <?php
            foreach ($boxMessages as $message) {
                try {
                    $msgContent = $encryption->decrypt($message->getMessage());
                    $msgTitle = $encryption->decrypt($message->getTitle());
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($message->getId())."</td>";
                    echo "<td>".htmlspecialchars($message->getSender())."</td>";
                    echo "<td>".htmlspecialchars($message->getRecipient())."</td>";
                    echo "<td>".htmlspecialchars($msgTitle)."</td>";
                    echo "<td>".htmlspecialchars($msgContent)."</td>";
                    echo "<td>".htmlspecialchars($message->getMessageDate())."</td>";
                    echo "<td>". ($message->isRead() ? '' : 'new') ."</td>";
                    echo "</tr>";
                } catch (Exception $e) {
                    error_log('Failed to decrypt message ' . $message->getId());
                }
            }
            ?>
        </table>
            </div>
</body>

</html>