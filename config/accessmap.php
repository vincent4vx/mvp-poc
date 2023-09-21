<?php

use Quatrevieux\Mvp\App\User\Profile\ProfileRequest;

return [
    ProfileRequest::class => (fn (ProfileRequest $request) => $request->user !== null),
];
