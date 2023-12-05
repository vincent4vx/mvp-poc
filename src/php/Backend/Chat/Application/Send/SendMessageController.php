<?php

namespace Quatrevieux\Mvp\Backend\Chat\Application\Send;

use Quatrevieux\Mvp\Backend\Chat\Command\SendChatMessage;
use Quatrevieux\Mvp\Backend\Chat\Domain\ValueObject\MessageContent;
use Quatrevieux\Mvp\Core\Bus\BusDispatcherInterface;
use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(SendMessageRequest::class)]
class SendMessageController implements ControllerInterface
{
    public function __construct(
        private readonly BusDispatcherInterface $dispatcher,
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

        $command = new SendChatMessage(
            message: MessageContent::tryFrom($request->message),
            userId: $request->user->id,
            createdAt: new \DateTimeImmutable(),
        );

        $message = $this->dispatcher->dispatch($command);

        return new SendMessageResponse($message);
    }
}
