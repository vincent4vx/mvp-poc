<?php

use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Profile\ProfileRequest;

return [
    ProfileRequest::class => (fn (ProfileRequest $request) => $request->user !== null),
];
