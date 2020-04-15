<?php
/**
 * Connect to the database and return a PDO.
 *
 * @return A PDO that can be used to interact with the database.
 */
function get_db_pdo()
{
    // Get the database URL from the environment
    $db = parse_url(getenv("DATABASE_URL"));
    if(empty($db["path"])) {
        http_response_code(500);
        exit();
    }
    $db["path"] = ltrim($db["path"], "/");

    // Connect to the database
    try {
        // Data Source Name (DSN)
        $dsn = "pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $db["host"], $db["port"], $db["user"], $db["pass"], $db["path"]
        );

        // PHP Data Object (PDO)
        $pdo = new PDO($dsn);
    } catch (PDOException $e) {
        http_response_code(500);
        exit();
    }

    return $pdo;
}
?>
