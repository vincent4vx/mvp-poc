<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserFormResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\BackOffice\CreateUserFormRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create\CreateUserRequest;

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

    <input type="submit" value="Submit">
</form>
