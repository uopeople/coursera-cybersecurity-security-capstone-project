<?php
/**
 * @var string|null $pageTitle
 * @var string $htmlContent
 */

use lib\components\Banner;

?>

<body>
<div class="page">

    <?= Banner::renderAppBanner($pageTitle); ?>

    <div class="container">
        <?= $htmlContent ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
