<?php

namespace Quatrevieux\Mvp\Frontend;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Core\View\ViewContext;

class ApplicationViewContext extends ViewContext
{
    public ?AuthenticatedUser $user = null;
    public bool $ajax = false;

    public function __construct(
        ServerRequestInterface $request,
        object $query,
        object $response,
    ) {
        parent::__construct($request, $query, $response);
    }
}
