<?php

include __DIR__ . '/setup.php';

use lib\db\Connection;

$pdo = Connection::get_db_pdo();
if (!empty($pdo)) {
    echo '<h1>DB connection test</h1>';
    echo 'It seems database connection works!';
}
