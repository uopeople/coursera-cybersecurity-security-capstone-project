<?php
/**
 * Params:
 *
 * @var string|null $pageTitle
 */

use lib\components\AppInfo;

?>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1"/>

    <!-- TODO maybe just use our group name, instead of each of our names as author? -->
    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">

    <title><?= (isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '') . htmlspecialchars(AppInfo::APP_NAME) ?></title>

    <!-- CSS -->
    <link rel="stylesheet" media="all" href="<?= AppInfo::urlCss('bulma.css') ?>">
    <link rel="stylesheet" media="all" href="<?= AppInfo::urlCss('index.css') ?>">

    <!-- Fonts -->
    <!-- TODO discuss if we want to rely on this CDN resource. Alternative: copy all icons we need as SVG to templates/icons.php. We probably need only a few icons, so the icons can be included directly on the page. -->
    <!-- To include, use <svg class="icon"><use xlink:href="#the-icon-id"></svg>; (see templates/pages/index.php as example) -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
