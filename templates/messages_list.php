<?php

/**
 * @var \lib\model\MessageView[] $boxMessages;
 */
?>

<div>
    <?php foreach ($boxMessages as $m): ?>
    <section class="section">
        <h3 class="size-2">
            <?= htmlspecialchars($m->getDecryptedTitle()) ?>
        </h3>
        <p>From: <?= htmlspecialchars($m->getSenderName()); ?></p>
        <p>To: <?= htmlspecialchars($m->getRecipientName()); ?></p>
        <p>Date/Time (UTC): <?= htmlspecialchars($m->getMessage()->getMessageDate()); ?></p>
        <p class="message-body">
            <?= htmlspecialchars($m->getDecryptedMessageBody()) ?>
        </p>
    </section>
    <hr>
    <?php endforeach; ?>
</div>
