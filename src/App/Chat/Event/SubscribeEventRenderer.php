<?php

namespace Quatrevieux\Mvp\App\Chat\Event;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Core\RendererInterface;
use Quatrevieux\Mvp\Core\StreamingResponse;
use Quatrevieux\Mvp\Core\StreamingResponseInterface;
use Quatrevieux\Mvp\Core\View;

final class SubscribeEventRenderer implements RendererInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    /**
     * @param View $view
     * @param SubscribeEventResponse $data
     * @return StreamingResponseInterface
     */
    public function render(View $view, object $data): StreamingResponseInterface
    {
        $response = $this->responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withHeader('Cache-Control', 'no-cache')
            // @todo add \n\n body ?
        ;

        return new StreamingResponse(
            $response,
            function () use ($data) {
                foreach ($data->events() as $event) {
                    yield "data: {$event->name}\n\n";
                }
            },
        );
        //
        //foreach ($data->events() as $event) {
        //    echo "data: {$event->name}\n\n";
        //    ob_end_flush();
        //    flush();
        //
        //    // On ferme la boucle si le client a interrompu la connexion
        //    // (par exemple en fermant la page)
        //    if (connection_aborted()) {
        //        break;
        //    }
        //}
        //
        //exit;
    }
}
