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
     * Create a UUID
     */
    private function makeUuid() {
        $data = openssl_random_pseudo_bytes( 16 );
        return vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split( bin2hex( $data ), 4 ) );
    }

    /**
     * Extract all rows from all tables and create files containing DB data.
     *
     * @return array List containing paths to the files created.
     */
    public function loadAllRowsFromAllTables(): array
    {
        $files = array();

        $sql = 'SELECT table_name FROM information_schema.tables '
               . "WHERE table_schema = 'public' ORDER BY table_name";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute()) {
            while ($tableName = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $table = $tableName['table_name'];
                // echo "<h3>" . $table . "</h3>";
                $filename = $this->loadAndDumpAllRowsFromTable($table);
                // array_push($files, $filename);
                $files[$table] = $filename;
            }
        }

        return $files;
    }

    /**
     * Create a file containing all DB data for a particular table.
     *
     * @param string $tableName The name of the table.
     *
     * @return string The name of the file.
     */
    private function loadAndDumpAllRowsFromTable(string $tableName): string
    {
        $filename = "db_dump_" . $tableName . "_" . $this->makeUuid() . ".txt";

        // Ensure file is empty
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        fwrite($myfile, "");
        fclose($myfile);

        // Concatenating the table name is safe here, since the tableName is obtained from the database itself.
        $sql = 'SELECT * FROM ' . $tableName;
        $stmt = $this->pdo->prepare($sql);

        // Write DB data to file
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $myfile = fopen($filename, "a+") or die("Unable to open file!");
                foreach($row as $key => $value) {
                    fwrite($myfile, $key . ": " . $value . "\n");
                }
                fwrite($myfile, "\n");
                fclose($myfile);
            }
        }

        return $filename;
    }
}
