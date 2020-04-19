<?php

include '../setup.php';

$pageTitle = 'Home';

// store pages/index.php as $htmlContent
ob_start();
include TEMPLATE_DIR . '/pages/index.php';
$htmlContent = ob_get_clean();

// then render the page.
include TEMPLATE_DIR . '/page.php';
