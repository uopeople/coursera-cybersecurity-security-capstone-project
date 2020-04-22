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
    <?php include BASE_DIR . '/templates/messages-list.php'; ?>
</div>
