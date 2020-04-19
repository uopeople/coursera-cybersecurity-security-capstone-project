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
    public function loadAllrowsFromAllTables()
    {
        $this->loadAndDumpAllRowsFromTable("users");
        return $this->loadAndDumpAllRowsFromTable("message");
        
    }

    private function loadAndDumpAllRowsFromTable(string $tableName): void
    {
        
        $sql = 'SELECT * FROM ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tableName]);
        $rows[] = $stmt->fetch(PDO::FETCH_ASSOC);
         if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->CreateOrAddToFileFromDbRecord($row, $tableName);
            }
        }
         
    }
    
    private function CreateOrAddToFileFromDbRecord(array $dbRecord, string $tableName): string
    {
        $filename= "dbdump.csv";
        $myfile = fopen("../public/".$filename, "a+") or die("Unable to open file!");
        
        $i=0;
        fwrite($myfile, "DUMP TABLE ".$tableName."\n");
        while($i<count($dbRecord))
         {   
             fwrite($myfile, $dbRecord[i].";");
             $i++;
         }
        fwrite($myfile,"\n");
        fclose($myfile);
        
        return $filename;
    }
}
