<?php
/**
 * @var Quatrevieux\Mvp\App\MenuBar $this
 * @var \Quatrevieux\Mvp\Core\Renderer $renderer
 */

use Quatrevieux\Mvp\App\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\App\User\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\App\User\Logout\LogoutRequest;
use Quatrevieux\Mvp\App\User\Profile\ProfileRequest;
use Quatrevieux\Mvp\App\User\RegistrationForm\RegistrationFormRequest;

?>

<nav>
    <ul>
        <?php if (!$this->user): ?>
            <li><a href="<?= $renderer->url(new AuthenticationFormRequest()) ?>">Login</a></li>
            <li><a href="<?= $renderer->url(new RegistrationFormRequest()) ?>">Register</a></li>
        <?php else: ?>
            <li><a href="<?= $renderer->url(new ShowChatRequest()) ?>">Chat</a></li>
            <li><a href="<?= $renderer->url(new ProfileRequest()) ?>"><?= htmlentities($this->user->pseudo) ?></a></li>
            <li><a href="<?= $renderer->url(new LogoutRequest()) ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
