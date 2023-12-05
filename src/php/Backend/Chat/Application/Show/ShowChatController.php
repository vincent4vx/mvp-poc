<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Show;

use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

use function array_map;
use function array_values;

#[Handles(ShowChatRequest::class)]
class ShowChatController implements ControllerInterface
{
    public function __construct(
        private readonly ChatMessageReadRepositoryInterface $repository,
        private readonly UserReadRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @param ShowChatRequest $request
     * @return ShowChatResponse
     */
    public function handle(object $request): ShowChatResponse
    {
        $messages = $this->repository->all();
        $usersIds = [];

        foreach ($messages as $message) {
            if ($message->userId !== null) {
                $usersIds[$message->userId->value] = $message->userId->value;
            }
        }

        $users = $this->userRepository->findAllById(array_values($usersIds));

        return new ShowChatResponse(
            messages: array_map(
                function ($message) use ($users, $request) {
                    if ($message->userId) {
                        $user = $users[$message->userId->value] ?? null;
                    } else {
                        $user = null;
                    }

                    return new ChatMessageWithUser(
                        id: $message->id,
                        message: $message->message,
                        createdAt: $message->createdAt,
                        isMine: $message->userId && $message->userId == $request->user?->id,
                        pseudo: $user?->pseudo,
                    );
                },
                $messages,
            ),
            ajax: $request->ajax,
        );
    }
}
