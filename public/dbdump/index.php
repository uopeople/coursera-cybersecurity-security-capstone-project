<?php
include __DIR__ . '/../../setup.php';

use lib\db\Dump;

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
<div class="container main">
    <h2>DB Dump</h2>
    <?php
        $dump = new Dump();
        $filename = $dump->loadAllRowsFromAllTables();
    ?>
</body>

</html>
