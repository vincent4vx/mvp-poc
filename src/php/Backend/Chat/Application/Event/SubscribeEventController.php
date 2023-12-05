<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Event;

use Quatrevieux\Mvp\Backend\Chat\Infrastructure\PDO\PdoChatMessagesRepository;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SubscribeEventRequest::class)]
final class SubscribeEventController implements ControllerInterface
{
    public function __construct(
        private PdoChatMessagesRepository $repository,
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
