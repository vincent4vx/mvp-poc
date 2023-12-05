<?php

namespace Quatrevieux\Mvp\Backend\Chat\Infrastructure\PDO;

use PDO;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessage;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageCreation;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\ChatMessageId;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;

class PdoChatMessagesRepository implements ChatMessageReadRepositoryInterface, ChatMessageWriteRepositoryInterface
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * @return ChatMessage[]
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM chat_message ORDER BY created_at DESC LIMIT 100');
        $messages = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messages[] = $this->instantiate($row);
        }

        return array_reverse($messages);
    }

    public function lastMessageId(): int
    {
        $stmt = $this->pdo->query('SELECT MAX(id) as id FROM chat_message');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['id'];
    }

    private function instantiate(array $row): ChatMessage
    {
        return new ChatMessage(
            id: ChatMessageId::from((int) $row['id']),
            message: MessageContent::from($row['message']),
            userId: UserId::tryFrom($row['user_id']),
            createdAt: new \DateTimeImmutable($row['created_at']),
        );
    }

    public function add(ChatMessageCreation $message): ChatMessage
    {
        $stmt = $this->pdo->prepare('INSERT INTO chat_message (user_id, message, created_at) VALUES (:user_id, :message, :created_at)');

        $stmt->bindValue('user_id', $message->userId->value, PDO::PARAM_INT);
        $stmt->bindValue('message', $message->message->value, PDO::PARAM_STR);
        $stmt->bindValue('created_at', $message->createdAt->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        $stmt->execute();

        return $message->created(ChatMessageId::from((int) $this->pdo->lastInsertId()));
    }
}
