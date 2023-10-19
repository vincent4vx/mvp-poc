<?php

use Quatrevieux\Mvp\Backend\User\Profile\ProfileRequest;

return [
    ProfileRequest::class => (fn (ProfileRequest $request) => $request->user !== null),
];
