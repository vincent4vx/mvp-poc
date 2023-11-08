<?php
/**
 * @var \Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm\AuthenticationFormResponse $this
 * @var \Quatrevieux\Mvp\Frontend\User\AuthenticationFormRenderer $renderer
 */

use Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication\AuthenticationRequest;

?>

<h1>Login</h1>

<?php if ($this->error): ?>
    <p class="error"><?= $this->error ?></p>
<?php endif; ?>

<form action="<?= $renderer->url(new AuthenticationRequest()); ?>" method="post" id="authentication-form">
    <?php if ($this->target): ?>
        <input type="hidden" name="target" value="<?= htmlentities($renderer->url($this->target)) ?>" />
        <!-- TODO: csrf security : target should be signed / use safe structure -->
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="submit" value="Login" />
</form>
