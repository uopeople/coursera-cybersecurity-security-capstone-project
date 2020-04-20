<?php
include __DIR__ . '/../setup.php';

use lib\db\Messages;

if (!isset($_SESSION['user'])) {
    header('Location: /login.php?message=login_required', true, 303);
    exit();
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
    <i class="fas fa-comments icon"></i>
    <h1>Coursera Capstone Project Messaging System</h1>
</div>
<div class="container main">
    <h2>Inbox</h2>
    <div>
        <div>
            <a href="write_message.php">Create New Message</a> <!-- review write_message page address -->
        </div>
        <div>
            <?php
                $user = $_SESSION["user"];
                $userid = $user->getId();
                $message = new Messages();
                $inboxMessages = $message->loadMessagesByRecipient($userid);
            ?>
            <table>
                <tr>
                    <th>From</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Read</th>
                </tr>
                <?php
                $i = 0;
                while ($i < count($inboxMessages)) {
                    $message = $inboxMessages[$i];
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($message->getSender())."</td>";
                    echo "<td>".htmlspecialchars($message->getMessageDate())."</td>";
                    echo "<td>".htmlspecialchars($message->getTitle())."</td>";
                    echo "<td>".htmlspecialchars($message->getMessage())."</td>";
                    echo "<td>".htmlspecialchars($message->isRead())."</td>";
                    echo "</tr>";
                    $i++;
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
