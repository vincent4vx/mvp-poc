<?php
/**
 * @var \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormResponse $this
 * @var \Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRenderer $renderer
 */

use Quatrevieux\Mvp\App\User\Authentication\AuthenticationRequest;

?>

<h2>Login</h2>

<?php if ($this->error): ?>
    <p class="error"><?= $this->error ?></p>
<?php endif; ?>

<form action="<?= $renderer->url(new AuthenticationRequest()); ?>" method="post" id="authentication-form">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="submit" value="Login" />
</form>
