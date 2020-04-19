<?php

/**
 * This file should be included by every php script. It sets up the composer autoloader,
 * allowing us to use classes via namespace and classname (without extra include / include_once).
 */

include __DIR__ . '/vendor/autoload.php';

define('TEMPLATE_DIR', __DIR__ . '/templates');