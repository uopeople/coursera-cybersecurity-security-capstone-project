<?php

include __DIR__ . '/../setup.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    echo 'Invalid method';
    http_response_code(405);
    return;
}

// TODO handle login form...
