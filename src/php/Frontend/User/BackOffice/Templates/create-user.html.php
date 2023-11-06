<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserFormRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserRequest;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;

?>

<h1>Create user</h1>

<form action="<?= $renderer->url(new CreateUserRequest()) ?>" method="post" id="user-form">
    <label for="username">Username</label>
    <?php if (isset($this->errors['username'])): ?>
        <span class="error"><?= $this->errors['username'] ?></span>
    <?php endif; ?>
    <input type="text" name="username" id="username" value="<?= htmlentities($this->username) ?>" />

    <label for="pseudo">Pseudo</label>
    <?php if (isset($this->errors['pseudo'])): ?>
        <span class="error"><?= $this->errors['pseudo'] ?></span>
    <?php endif; ?>
    <input type="text" name="pseudo" id="pseudo" value="<?= htmlentities($this->pseudo) ?>" />

    <label for="password">Password</label>
    <?php if (isset($this->errors['password'])): ?>
        <span class="error"><?= $this->errors['password'] ?></span>
    <?php endif; ?>
    <input type="password" name="password" id="password" />

    <label for="roles">Roles</label>

    <select multiple name="roles[]" id="roles">
        <?php foreach (UserRole::cases() as $role): ?>
            <option value="<?= $role->value ?>" <?= in_array($role, $this->roles) ? 'selected' : '' ?>><?= $role->label() ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Submit">
</form>
