<?php

namespace Quatrevieux\Mvp\App\Chat\Send;

use Quatrevieux\Mvp\App\Chat\ChatMessage;
use Quatrevieux\Mvp\App\Chat\ChatMessagesRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SendMessageRequest::class)]
class SendMessageController implements ControllerInterface
{
    public function __construct(
        private readonly ChatMessagesRepository $repository,
    ) {
    }

    /**
     * @param SendMessageRequest $request
     * @return SendMessageResponse
     */
    public function handle(object $request): SendMessageResponse
    {
        if (!$request->message) {
            return new SendMessageResponse();
        }

        $message = $this->repository->add(new ChatMessage(
            id: -1,
            message: $request->message,
            userId: $request->user->id,
            createdAt: new \DateTimeImmutable(),
        ));

        return new SendMessageResponse($message);
    }
}
