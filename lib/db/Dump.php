<?php


namespace lib\db;

use Exception;
use PDO;

/**
 * Database dump
 */
class Dump
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Dump constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->pdo = Connection::get_db_pdo();
    }

    /**
     * Extract all rows from all table and write in csv file
     *
     * @return string
     */
    public function loadAllRowsFromAllTables()
    {
        $this->loadAndDumpAllRowsFromTable("users");
        $this->loadAndDumpAllRowsFromTable("messages");
        
    }

    private function loadAndDumpAllRowsFromTable(string $tableName): void
    {
        $sql = 'SELECT * FROM ' . $tableName;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows[] = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->execute()) {
            echo "<h3>" . $tableName . "</h3>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>";
                foreach($row as $key => $value) {
                    echo $key . ": " . $value . "<br />";
                }
                echo "</p>";
            }
        }
    }
}
