<?php

namespace Quatrevieux\Mvp\Backend\Chat\Show;

use Quatrevieux\Mvp\Backend\Chat\ChatMessagesRepository;
use Quatrevieux\Mvp\Backend\User\Infrastructure\PDO\UserRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

use function array_map;
use function array_values;

#[Handles(ShowChatRequest::class)]
class ShowChatController implements ControllerInterface
{
    public function __construct(
        private readonly ChatMessagesRepository $repository,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @param object $request
     * @return object
     */
    public function handle(object $request): object
    {
        $messages = $this->repository->all();
        $usersIds = [];

        foreach ($messages as $message) {
            $usersIds[$message->userId] = $message->userId;
        }

        $users = $this->userRepository->findAllById(array_values($usersIds));

        return new ShowChatResponse(
            messages: array_map(
                fn ($message) => new ChatMessageWithUser(
                    id: $message->id,
                    message: $message->message,
                    createdAt: $message->createdAt,
                    user: $users[$message->userId] ?? null,
                ),
                $messages,
            ),
            user: $request->user,
            ajax: $request->ajax,
        );
    }
}
