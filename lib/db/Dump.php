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
        $sql = 'SELECT table_name FROM information_schema.tables '
               . "WHERE table_schema = 'public' ORDER BY table_name";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute()) {
            while ($tableName = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $table = $tableName['table_name'];
                echo "<h3>" . $table . "</h3>";
                $this->loadAndDumpAllRowsFromTable($table);
            }
        }
        
    }

    private function loadAndDumpAllRowsFromTable(string $tableName): void
    {
        // Concatenating the table name is safe here, since the tableName is obtained from the database itself.
        $sql = 'SELECT * FROM ' . $tableName;
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute()) {
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
