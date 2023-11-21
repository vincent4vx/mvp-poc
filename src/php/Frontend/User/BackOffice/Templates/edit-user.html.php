<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit\EditUserResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\BackOffice\EditUserRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save\SaveUserRequest;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;

?>

<h1>Edit user <?= $this->user->username->html() ?></h1>

<?php if ($this->globalError): ?>
    <span class="error"><?= htmlentities($this->globalError) ?></span>
<?php endif; ?>

<form action="<?= $renderer->url(new SaveUserRequest()) ?>" method="post" id="edit-user-form">
    <input type="hidden" name="id" value="<?= $this->user->id->value ?>" />

    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= $this->user->username->html() ?>" readonly />

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
