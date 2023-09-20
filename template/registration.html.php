<?php

/**
 * @var Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormResponse $this
 * @var Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRenderer $renderer
 * @var \Quatrevieux\Mvp\App\CustomViewContext $context
 */

use Quatrevieux\Mvp\App\User\Registration\RegistrationRequest;

$context->title = 'My Blog - Registration';

?>

<h2>Registration</h2>

<?php if ($this->errors): ?>
    <!-- TODO: htmlentities -->
    <div class="error"><?= implode('<br />', $this->errors) ?></div>
<?php endif ?>

<form action="<?= htmlentities($renderer->url(new RegistrationRequest())) ?>" method="post">
    <input name="username" placeholder="Username" value="<?= htmlentities($this->username ?? '') ?>" />
    <input name="pseudo" value="<?= htmlentities($this->pseudo ?? '') ?>" />
    <input name="password" placeholder="Password" type="password" />
    <input name="passwordConfirm" placeholder="Repeat password" type="password" />
    <input type="submit" value="Register" />
</form>
