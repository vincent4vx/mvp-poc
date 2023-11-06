<?php

namespace Quatrevieux\Mvp\Backend\Chat;

use Quatrevieux\Mvp\Backend\Chat\Event\SubscribeEventController;
use Quatrevieux\Mvp\Backend\Chat\Event\SubscribeEventRequest;
use Quatrevieux\Mvp\Backend\Chat\Send\SendMessageController;
use Quatrevieux\Mvp\Backend\Chat\Send\SendMessageRequest;
use Quatrevieux\Mvp\Backend\Chat\Show\ShowChatController;
use Quatrevieux\Mvp\Backend\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\Core\Module\AbstractModule;
use Quatrevieux\Mvp\Core\Module\ModuleBuilder;
use Quatrevieux\Mvp\Frontend\Chat\SendMessageRenderer;
use Quatrevieux\Mvp\Frontend\Chat\SubscribeEventRenderer;

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
    }
}
