<?php

namespace Quatrevieux\Mvp\App;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\User\AuthenticatedUser;
use Quatrevieux\Mvp\Core\ViewContext;

class CustomViewContext extends ViewContext
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
