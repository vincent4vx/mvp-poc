<?php

namespace Quatrevieux\Mvp\App;

use Psr\Http\Message\ServerRequestInterface;
use Quatrevieux\Mvp\App\User\User;
use Quatrevieux\Mvp\Core\ViewContext;

class CustomViewContext extends ViewContext
{
    public ?User $user = null;

    public function __construct(
        ServerRequestInterface $request,
        object $query,
        object $response,
    ) {
        parent::__construct($request, $query, $response);
    }
}
