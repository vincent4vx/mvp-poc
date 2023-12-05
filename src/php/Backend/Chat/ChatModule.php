<?php

namespace Quatrevieux\Mvp\Backend\Chat;

use Quatrevieux\Mvp\Backend\Chat\Application\Event\SubscribeEventController;
use Quatrevieux\Mvp\Backend\Chat\Application\Event\SubscribeEventRequest;
use Quatrevieux\Mvp\Backend\Chat\Application\Send\SendMessageController;
use Quatrevieux\Mvp\Backend\Chat\Application\Send\SendMessageRequest;
use Quatrevieux\Mvp\Backend\Chat\Application\Show\ShowChatController;
use Quatrevieux\Mvp\Backend\Chat\Application\Show\ShowChatRequest;
use Quatrevieux\Mvp\Backend\Chat\Command\SendChatMessage;
use Quatrevieux\Mvp\Backend\Chat\Command\SendChatMessageHandler;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageReadRepositoryInterface;
use Quatrevieux\Mvp\Backend\Chat\Domain\ChatMessageWriteRepositoryInterface;
use Quatrevieux\Mvp\Backend\Chat\Infrastructure\PDO\PdoChatMessagesRepository;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Frontend\Chat\SendMessageRenderer;
use Quatrevieux\Mvp\Frontend\Chat\SubscribeEventRenderer;

use function DI\autowire;
use function DI\get;

class ChatModule extends AbstractModule
{
    protected function build(ModuleBuilder $builder): void
    {
        $builder
            ->prefix('/chat')
            ->anonymousByDefault()
        ;

        $builder->route('/show', ShowChatRequest::class)
            ->controller(ShowChatController::class)
            ->renderer(__DIR__ . '/../../Frontend/Chat/Templates/chat.html.php')
        ;

        $builder->route('/send', SendMessageRequest::class)
            ->controller(SendMessageController::class)
            ->renderer(SendMessageRenderer::class)
            ->authenticated()
        ;

        $builder->route('/subscribe', SubscribeEventRequest::class)
            ->controller(SubscribeEventController::class)
            ->renderer(SubscribeEventRenderer::class)
        ;

        $builder->definition(PdoChatMessagesRepository::class, autowire());
        $builder->definition(ChatMessageReadRepositoryInterface::class, get(PdoChatMessagesRepository::class));
        $builder->definition(ChatMessageWriteRepositoryInterface::class, get(PdoChatMessagesRepository::class));

        $builder->handler(SendChatMessage::class, SendChatMessageHandler::class);
    }
}
