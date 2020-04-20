<?php

use lib\components\AppInfo;

/**
 * @var \lib\model\MessageView[] $boxMessages
 * @var string                   $pageTitle
 * @var bool|null                $linkToInbox
 * @var bool|null                $linkToSentBox
 *
 */
?>

<div id="header" class="is-size-1">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
</div>


<div>
    <?php include BASE_DIR . '/templates/messages_list.php'; ?>
</div>


<div id="main-links">
    <p>
        <a href="<?= AppInfo::urlWriteMessage() ?>" class="large-font">Create New Message</a> <!-- review write-message page address -->
    </p>

    <?php if (isset($linkToInbox) && $linkToInbox): ?>
        <p class="link-to-message-box">
            <a href="<?= AppInfo::urlInbox() ?>" class="large-font">To Inbox</a>
        </p>
    <?php endif; ?>

    <?php if (isset($linkToSentBox) && $linkToSentBox): ?>
        <p class="link-to-message-box">
            <a href="<?= AppInfo::urlSentMessages() ?>" class="large-font">To Sent messages</a>
        </p>
    <?php endif; ?>

</div>
