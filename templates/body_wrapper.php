<?php
/**
 * @var string|null $pageTitle
 * @var string      $htmlContent
 */

use lib\components\AppInfo;
use lib\components\Banner;
use lib\service\SessionManagerPhp;

$sessMgr = new SessionManagerPhp();
$user = $sessMgr->getAuthenticatedUser();
?>

<body>
<div class="page">

    <?= Banner::renderAppBanner($pageTitle); ?>

    <?php if ($user): ?>
        <section class="section">
            <nav class="level">
                <div class="level-left">&nbsp;</div>
                <div class="level-right">
                    <p class="level-item"><a class="button" href="<?= AppInfo::urlInbox() ?>">Inbox</a></p>
                    <p class="level-item"><a class="button" href="<?= AppInfo::urlSentMessages() ?>">Sent messages</a></p>
                    <form class="level-item nav-logout" method="post" action="<?= AppInfo::urlLogout() ?>">
                        <button type="submit" class="button is-dark">Logout</button>
                    </form>
                    <p class="level-item">
                        <span class="icon">
                            <svg focusable="false" class="svg-inline--fa fa-user fa-w-14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path
                                        fill="currentColor"
                                        d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
                        </span>
                        <span class="nav-username"><?= $user->getUsername() ?></span>
                    </p>
                </div>
            </nav>
        </section>
    <?php endif; ?>


    <div class="container">
        <?= $htmlContent ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
