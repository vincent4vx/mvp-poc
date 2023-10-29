<?php

namespace Quatrevieux\Mvp\Backend\BackOffice\Home;

use Quatrevieux\Mvp\Core\ControllerInterface;
use Quatrevieux\Mvp\Core\Handles;

#[Handles(HomeRequest::class)]
class HomeController implements ControllerInterface
{
    public function handle(object $request): HomeResponse
    {
        return new HomeResponse();
    }
}
