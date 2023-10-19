<?php

namespace Quatrevieux\Mvp\Backend\Chat\Send;

use Quatrevieux\Mvp\Backend\Chat\ChatMessage;
use Quatrevieux\Mvp\Backend\Chat\ChatMessagesRepository;
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
            userId: $request->user->id->value,
            createdAt: new \DateTimeImmutable(),
        ));

        return new SendMessageResponse($message);
    }
}
