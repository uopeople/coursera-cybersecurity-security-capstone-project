<?php


namespace lib\model;

/**
 * A user entity
 *
 */
class Message
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $sender;

    /**
     * @var string
     */
    private $recipient;

    /**
     ** @var string
     */
    private $message;

    /**
     * @var string
     */
    private $messageDate;

    /**
     * @param int $id
     * @param int $sender
     * @param int $recipient
     * @param string $message
     * @param string $messageDate
     * @param bool $read
     */
    public function __construct(
        int $id,
        int $sender,
        int $recipient,
        string $message,
        string $messageDate,
        bool $read
    )
    {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->message = $message;
        $this->messageDate = $messageDate;
        $this->read = $read;
        }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSender(): int
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getRecipient(): int
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function getRead(): bool
    {
        return $this->read;
    }

    
}