<?php

include __DIR__ . '/setup.php';

use lib\db\Connection;
use lib\db\Users;

$pdo = Connection::get_db_pdo();
if (!empty($pdo)) {
    echo '<h1>DB connection test</h1>';
    echo '<p>It seems database connection works!</p>';
}

// try to register a new user
$users = new Users();
$ok = $users->registerNewUser('peter', 'peter@example.com', 'very-secret');
if ($ok) {
    echo '<p>Successfully created user "peter"</p>';
} else {
    echo '<p>Failed to create new user</p>';
}

$peter = $users->loadUserByUsername('peter');
echo '<pre>';
var_dump($peter);
echo '</pre>';
