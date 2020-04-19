<?php
/**
 * @var string $pageTitle
 * @var string $htmlContent
 */

use lib\components\Banner;

?>

<body>
<div class="page">
    <?php include __DIR__ . '/icons.php'; ?>

    <?= Banner::renderAppBanner($pageTitle); ?>

    <div class="container">
        <?= $htmlContent ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
