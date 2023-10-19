<?php
/**
 * @var \Quatrevieux\Mvp\Frontend\Component\MenuBar $this
 * @var \Quatrevieux\Mvp\Core\Renderer $renderer
 */

use Quatrevieux\Mvp\Backend\Chat\Show\ShowChatRequest;
use Quatrevieux\Mvp\Backend\User\AuthenticationForm\AuthenticationFormRequest;
use Quatrevieux\Mvp\Backend\User\Logout\LogoutRequest;
use Quatrevieux\Mvp\Backend\User\Profile\ProfileRequest;
use Quatrevieux\Mvp\Backend\User\RegistrationForm\RegistrationFormRequest;

?>

<nav>
    <ul>
        <?php if (!$this->user): ?>
            <li><a href="<?= $renderer->url(new AuthenticationFormRequest()) ?>">Login</a></li>
            <li><a href="<?= $renderer->url(new RegistrationFormRequest()) ?>">Register</a></li>
        <?php else: ?>
            <li><a href="<?= $renderer->url(new ShowChatRequest()) ?>">Chat</a></li>
            <li><a href="<?= $renderer->url(new ProfileRequest()) ?>"><?= $this->user->pseudo->html() ?></a></li>
            <li><a href="<?= $renderer->url(new LogoutRequest()) ?>">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
