<?php
    // **********************************************
    // Database connection and configuration
    // **********************************************
    $db = parse_url(getenv("DATABASE_URL"));
    $db["path"] = ltrim($db["path"], "/");

    try {
        // Data Source Name (DSN)
        $dsn = "pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $db["host"], $db["port"], $db["user"], $db["pass"], $db["path"]
        );
        // PHP Data Object (PDO)
        $pdo = new PDO($dsn);
    } catch (PDOException $e) {
        // die("Connection failed: " . $e->getMessage());
        // echo $e->getMessage();

        // http_response_code(500);
        // die();

        header("HTTP/1.1 500 Internal Server Error");
        echo $e->getMessage();
        // exit(1);
    }
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1" />

    <meta name=author content="Daniel Petrescu">
    <title>Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
    <div id="header">
        <i class="fas fa-comments"></i>
        <h1>Coursera Capstone Project Messaging System</h1>
    </div>
    <div id="main-links">
        <p id="login">Log in</p>
        <p id="register">Register</p>
    </div>
</body>

</html>
