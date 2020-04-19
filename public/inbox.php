<!DOCTYPE html>
<html lang=en>

<?php
include __DIR__ . '/../setup.php';
?>

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
            <?php
            use lib\model\Messages;
            use lib\db\Messages;
            use PDO;
            if (isset($_SESSION['user']))
            {
                $user = $_SESSION["user"];
                $userid = $user->getId();
                $message = new Messages();
                $inboxMessages = $message->loadMessagesByRecipient($userid);
            }
            else 
            header('Location: /login.php', true, 303);
            
            
           ?>
        <table>
            <tr>
                <td>Id</td>
                <td>Sender</td>
                <td>Recipient</td>
                <td>Message</td>
                <td>Date</td>
                <td>Read</td>
            </tr>
            <?php
               while ($i < count($inboxMessages)) {
                   $message = $inboxMessages[$i];
                   echo "<tr>";
                   echo "<td>".htmlspecialchars($message->id)."</td>";
                   echo "<td>".htmlspecialchars($message->sender)."</td>";
                   echo "<td>".htmlspecialchars($message->recipient)."</td>";
                   echo "<td>".htmlspecialchars($message->message)."</td>";
                   echo "<td>".htmlspecialchars($message->messageDate)."</td>";
                   echo "<td>".htmlspecialchars($message->read)."</td>";
                   echo "</tr>";
                   $i++;
               }

            ?>
        </table>
            </div>
</body>

</html>