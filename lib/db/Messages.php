<?php


namespace lib\db;

use lib\model\Message;
use PDO;

/**
 * Access to database table 'messages'
 */
class Messages
{

    /**
     * @var PDO
     */
    private $pdo;


    public function __construct()
    {
        $this->pdo = Connection::get_db_pdo();
    }

    /**
     * Returns the message with the given message id. If no such message exists, this function returns null.
     *
     * @param int $messageId
     *
     * @return Message|null
     */
    public function loadMessageById(int $messageId): ?Message
    {
        
        $sql = 'SELECT id, sender, recipient, message, date, read FROM messages WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$messageId]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!message) {
            // not found
            return null;
        }
        return $this->createMessageEntityFromDbRecord(message);
    }


    /**
     * Returns messages whith the given sender.
     * 
     * @param string $senderId
     *
     * @return Message|null
     */
    public function loadMessagesBySender(int $senderId)
    {
        $sql = 'SELECT id, sender, recipient, message, date, read FROM messages WHERE sender = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$senderId]);
        $messages = [];
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $mesages[] =  $this->createMessageEntityFromDbRecord($row);
            }
        }
        return $mesages;
}
    

   /**
     * Returns messages whith the given recipient.
     * 
     * @param string $recipientId
     *
     * @return Message|null
     */
    public function loadMessagesByRecipient(int $recipientId)
    {
        $sql = 'SELECT id, sender, recipient, message, date, read FROM messages WHERE recipient = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$recipientId]);
        $messages = [];
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $mesages[] =  $this->createMessageEntityFromDbRecord($row);
            }
        }
        return $mesages;
    }

   

    public function insertNewMessage(int $sender, int $recipient, string $message, string $date, bool $read)
    {
          
        $sql = 'INSERT INTO messages (sender, recipient, message, date, read) VALUES (?, ?, ?, ?, ?)';

       
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$sender, $recipient, $message,$date,$read]);
            $cnt = $stmt->rowCount();
            if ($cnt < 1) {
                return false;
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    
    private function createMessageEntityFromDbRecord(array $dbRecord): Message
    {
         return new Message(
            intval($dbRecord['id']),
            intval($dbRecord['sender']),
            intval($dbRecord['recipient']),
            $dbRecord['message'],
            $dbRecord['date'],
            boolval($dbRecord['read'])
            
        );
    }
}