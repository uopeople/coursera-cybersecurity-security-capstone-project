<?php


namespace tests\db\lib\db;


use Exception;
use lib\db\Connection;
use lib\db\Messages;
use lib\db\Users;
use lib\model\User;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{

    /**
     * @var User
     */
    private $sender;

    /**
     * @var User
     */
    private $recipient;

    /**
     * @before
     * @throws Exception
     */
    public function setupDatabase()
    {
        $pdo = Connection::get_db_pdo();

        // clear users
        $stmt = $pdo->prepare('DELETE FROM users;');
        $stmt->execute();

        // create two dummy users, as sender/recipient
        $users = new Users($pdo);
        $users->registerNewUser('peter', 'peter@example.com', 'very-secret');
        $users->registerNewUser('lisa', 'lisa@example.com', 'very-secret');

        $this->sender = $users->loadUserByUsername('peter');
        $this->recipient = $users->loadUserByUsername('lisa');
    }

    public function test_insert_new_message_works()
    {
        $messages = new Messages();
        $ok = $messages->insertNewMessage(
            $this->sender->getId(),
            $this->recipient->getId(),
            'Hi joe',
            'test-message',
            '2020-03-03 10:10:10',
            false
        );
        $this->assertTrue($ok);
    }

}