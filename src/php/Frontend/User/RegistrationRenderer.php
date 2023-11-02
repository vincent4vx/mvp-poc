<?php

namespace Quatrevieux\Mvp\Frontend\User;

use Psr\Http\Message\ResponseInterface;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationResponse;
use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormResponse;
use Quatrevieux\Mvp\Core\Dispatcher;
use Quatrevieux\Mvp\Core\View\RendererInterface;
use Quatrevieux\Mvp\Core\View\View;

class RegistrationRenderer implements RendererInterface
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
    ) {
    }

    /**
     * @param View $view
     * @param RegistrationResponse $data
     * @return string|ResponseInterface
     */
    public function render(View $view, object $data): string|ResponseInterface
    {
        if (!$data->success) {
            return $view->renderResponse(new RegistrationFormResponse(
                $data->request->username,
                $data->request->pseudo,
                $data->errors,
            ));
        }

        // Forward to authentication, for performant auto-login
        $request = new AuthenticationRequest();

        $request->username = $data->user->username->value;
        $request->password = $data->request->password;

        return $view->renderResponse($this->dispatcher->handle($request));
    }
}
