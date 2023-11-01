<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration;

use Quatrevieux\Mvp\Backend\User\Domain\UserReadRepositoryInterface;
use Quatrevieux\Mvp\Core\Route;

#[Route('/registration')]
class RegistrationRequest
{
    public ?string $username = null;
    public ?string $pseudo = null;
    public ?string $password = null;
    public ?string $passwordConfirm = null;

    public function validate(UserReadRepositoryInterface $repository): array
    {
        $errors = [];

        if(empty($this->username)){
            $errors['username'] = 'Username is required';
        }

        if(empty($this->pseudo)){
            $errors['pseudo'] = 'Pseudo is required';
        }

        if(empty($this->password)){
            $errors['password'] = 'Password is required';
        }

        if(empty($this->passwordConfirm)){
            $errors['passwordConfirm'] = 'Password confirmation is required';
        }

        if($this->password !== $this->passwordConfirm){
            $errors['passwordConfirm'] = 'Password confirmation does not match';
        }

        if ($this->username && $repository->hasUsername($this->username)) {
            $errors['username'] = 'Username already exists';
        }

        return $errors;
    }
}
