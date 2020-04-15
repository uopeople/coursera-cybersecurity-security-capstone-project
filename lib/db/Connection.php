<?php

namespace lib\db;

use PDO;
use PDOException;

/**
 * Provides a reusable PDO connection
 */
class Connection {

    /**
     * @var \PDO
     */
    private static $pdo;

    /**
     * Connect to the database and return a PDO.
     *
     * @return PDO A PDO that can be used to interact with the database.
     */
    static function get_db_pdo(): PDO
    {
        if (isset(self::$pdo)) {
            return self::$pdo;
        }

        // Get the database URL from the environment
        $url = getenv("DATABASE_URL");
        if (!$url) {
            self::exitWithError('Cannot connect to the database (1)');
        }
        $db = parse_url($url);
        if(!$db || empty($db["path"])) {
            self::exitWithError('Failed to connect to database (2)');
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
            self::$pdo = new PDO($dsn);
        } catch (PDOException $e) {
            self::exitWithError('Failed to initialize database connection (3)');
        }

        return self::$pdo;
    }

    private static function exitWithError(string $errMsg)
    {
        echo htmlspecialchars($errMsg);
        http_response_code(500);
        exit();
    }

}

?>
