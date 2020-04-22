<?php
include __DIR__ . '/../../setup.php';

use lib\db\Dump;

// the tables that can be dumped...
$tables = ['users', 'messages'];

try {
    $dump = new Dump($tables);
} catch (Exception $e) {
    echo 'failed to initialize database connection';
    http_response_code(500);
}

if (isset($_GET['table']) && in_array($_GET['table'], $tables, true)) {
    // dump this table...
    $tableToDump = $_GET['table'];

    $filename = "$tableToDump.csv";

    $result = $dump->loadAllRowsFromTable($tableToDump);
    $out = fopen('php://output', 'wb');
    ob_start();
    foreach ($result as $row) {
        fputcsv($out, $row);
    }
    $data = ob_get_clean();

    // write response
    header("Expires: 0");
    header("Cache-Control: no-store");
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    echo $data;

    exit();
}

// if 'table' param is not set (or invalid), show list of links

?>

<html lang=en>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1"/>

    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Dump | Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=../css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
<div id="header">
    <i class="fas fa-comments"></i>
    <h1>Coursera Capstone Project Messaging System</h1>
</div>
<div id="dbdump-main">
    <h2>DB Dump</h2>
    <table id="dbdump-table">
        <tr>
            <th>Table</th>
            <th>Data</th>
        </tr>
        <?php foreach ($tables as $table): ?>
            <tr>
                <td>
                    <?php echo $table ?>
                </td>
                <td>
                    <a target="_blank" href="/dbdump/index.php?table=<?= urlencode($table) ?>">Download data</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
