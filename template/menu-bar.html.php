<?php
/**
 * @var Quatrevieux\Mvp\App\MenuBar $this
 * @var \Quatrevieux\Mvp\App\MenuBarRenderer $renderer
 */

use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\App\User\Logout\LogoutRequest;
use Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRequest;

?>

<nav>
    <ul>
        <?php if (!$this->user): ?>
            <li><a href="<?= $renderer->url(new AuthenticationFormRequest()) ?>">Login</a></li>
            <li><a href="<?= $renderer->url(new RegistrationFormRequest()) ?>">Register</a></li>
        <?php else: ?>
            <li><?= htmlentities($this->user->pseudo) ?></li>
            <li><a href="<?= $renderer->url(new LogoutRequest()) ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
