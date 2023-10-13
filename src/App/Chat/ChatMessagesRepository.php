<?php

namespace Quatrevieux\Mvp\App\Chat;

use PDO;

class ChatMessagesRepository
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
            id: $row['id'],
            message: $row['message'],
            userId: $row['user_id'],
            createdAt: new \DateTimeImmutable($row['created_at']),
        );
    }

    public function add(ChatMessage $param): ChatMessage
    {
        $stmt = $this->pdo->prepare('INSERT INTO chat_message (user_id, message, created_at) VALUES (:user_id, :message, :created_at)');

        $stmt->bindValue('user_id', $param->userId, PDO::PARAM_INT);
        $stmt->bindValue('message', $param->message, PDO::PARAM_STR);
        $stmt->bindValue('created_at', $param->createdAt->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        $stmt->execute();

        return new ChatMessage(
            id: $this->pdo->lastInsertId(),
            message: $param->message,
            userId: $param->userId,
            createdAt: $param->createdAt,
        );
    }
}
