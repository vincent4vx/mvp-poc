<?php

namespace Quatrevieux\Mvp\Backend\Chat\Event;

use Quatrevieux\Mvp\Backend\Chat\ChatMessagesRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SubscribeEventRequest::class)]
final class SubscribeEventController implements ControllerInterface
{
    public function __construct(
        private ChatMessagesRepository $repository,
    ) {
    }

    /**
     * @param object $request
     * @return SubscribeEventResponse
     */
    public function handle(object $request): SubscribeEventResponse
    {
        return new SubscribeEventResponse(function ($id) {
            $lastId = $this->repository->lastMessageId();

            if ($lastId > $id) {
                return new ChatEvent(
                    id: (string) $lastId,
                    name: 'chat_message',
                );
            }

            return null;
        });
    }
}
