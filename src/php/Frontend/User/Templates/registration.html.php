<?php

/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm\RegistrationFormResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\RegistrationFormRenderer $renderer
 * @var \Quatrevieux\Mvp\Frontend\ApplicationViewContext $context
 */

use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration\RegistrationRequest;

$context->title = 'My Blog - Registration';

?>

<h1>Registration</h1>

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
